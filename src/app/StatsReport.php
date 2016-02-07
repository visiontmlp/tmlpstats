<?php
namespace TmlpStats;

use Carbon\Carbon;
use Eloquence\Database\Traits\CamelCaseModel;
use Illuminate\Database\Eloquent\Model;
use TmlpStats\Settings\ReportDeadlines;
use TmlpStats\Traits\CachedRelationships;

class StatsReport extends Model
{
    use CamelCaseModel, CachedRelationships;

    protected $reportDeadlines = null;

    protected $fillable = [
        'reporting_date',
        'center_id',
        'quarter_id',
        'user_id',
        'version',
        'validated',
        'locked',
        'submitted_at',
        'submit_comment',
    ];

    protected $dates = [
        'reporting_date',
        'submitted_at',
    ];

    protected $casts = [
        'validated' => 'boolean',
        'locked'    => 'boolean',
    ];

    public function __get($name)
    {
        if ($name === 'quarter') {
            return Quarter::findForCenter($this->quarterId, $this->center);
        }

        return parent::__get($name);
    }

    /**
     * Was this report submitted on or before the deadline?
     *
     * @return bool
     */
    public function isOnTime()
    {
        $submittedAt = $this->submittedAt->copy();
        $submittedAt->setTimezone($this->center->timezone);

        return $submittedAt->lte($this->due());
    }

    /**
     * Get datetime object for when stats are due
     *
     * @return null|Carbon date
     */
    public function due()
    {
        if (!$this->reportDeadlines) {
            $this->reportDeadlines = ReportDeadlines::get($this->center, $this->quarter, $this->reportingDate);
        }

        return $this->reportDeadlines['report'];
    }

    /**
     * Get datetime object for when the regional statistician response is due
     *
     * @return null|Carbon date
     */
    public function responseDue()
    {
        if (!$this->reportDeadlines) {
            $this->reportDeadlines = ReportDeadlines::get($this->center, $this->quarter, $this->reportingDate);
        }

        return $this->reportDeadlines['response'];
    }

    /**
     * Did this report pass validation?
     *
     * @return bool
     */
    public function isValidated()
    {
        return $this->validated;
    }

    /**
     * Was this report officially submitted
     *
     * @return bool
     */
    public function isSubmitted()
    {
        return $this->submitted_at !== null;
    }

    /**
     * Get the points for this reporting week
     *
     * @return null|integer
     */
    public function getPoints()
    {
        $data = CenterStatsData::byStatsReport($this)
                               ->reportingDate($this->reportingDate)
                               ->actual()
                               ->first();

        return $data ? $data->points : null;
    }

    /**
     * Get the rating for this reporting week
     *
     * @return null|string
     */
    public function getRating()
    {
        $points = $this->getPoints();

        if ($points === null) {
            return null;
        }

        return static::pointsToRating($points);
    }

    /**
     * Get the integer percentage of actual performance against promise
     *
     * @param $actual
     * @param $promise
     *
     * @return int|integer
     */
    public static function calculatePercent($actual, $promise)
    {
        return $promise > 0
            ? max(min(round(($actual / $promise) * 100), 100), 0)
            : 0;
    }

    /**
     * Get the points based on gamer percentage
     *
     * @param $percent
     * @param $game
     *
     * @return int
     */
    public static function pointsByPercent($percent, $game)
    {
        $points = 0;

        if ($percent == 100) {
            $points = 4;
        } else if ($percent >= 90) {
            $points = 3;
        } else if ($percent >= 80) {
            $points = 2;
        } else if ($percent >= 75) {
            $points = 1;
        }

        return ($game == 'cap') ? $points * 2 : $points;
    }

    /**
     * Get the rating based on number of points
     *
     * @param $points
     *
     * @return string
     */
    public static function pointsToRating($points)
    {
        if ($points == 28) {
            return "Powerful";
        } else if ($points >= 22) {
            return "High Performing";
        } else if ($points >= 16) {
            return "Effective";
        } else if ($points >= 9) {
            return "Marginally Effective";
        } else {
            return "Ineffective";
        }
    }

    public function scopeByRegion($query, Region $region)
    {
        $childRegions    = $region->getChildRegions();
        $searchRegionIds = [];
        if ($childRegions) {
            foreach ($childRegions as $child) {
                $searchRegionIds[] = $child->id;
            }
        }
        $searchRegionIds[] = $region->id;

        return $query->whereIn('center_id', function ($query) use ($searchRegionIds) {
            $query->select('id')
                  ->from('centers')
                  ->whereIn('region_id', $searchRegionIds);
        });
    }

    public function scopeReportingDate($query, Carbon $date)
    {
        return $query->whereReportingDate($date);
    }

    public function scopeValidated($query, $validated = true)
    {
        return $query->whereValidated($validated);
    }

    public function scopeSubmitted($query, $submitted = true)
    {
        if ($submitted) {
            return $query->whereNotNull('submitted_at');
        } else {
            return $query->whereNull('submitted_at');
        }
    }

    public function scopeOfficial($query)
    {
        return $query->whereIn('id', function ($query) {
            $query->select('stats_report_id')
                  ->from('global_report_stats_report');
        });
    }

    public function scopeByCenter($query, Center $center)
    {
        return $query->whereCenterId($center->id);
    }

    public function scopeCurrentQuarter($query, Region $region = null)
    {
        $quarter = Quarter::getQuarterByDate(Util::getReportDate(), $region);
        if (!$quarter) {
            return $query;
        }

        return $query->whereQuarterId($quarter->id);
    }

    public function scopeLastQuarter($query, Region $region = null)
    {
        $currentQuarter = Quarter::getQuarterByDate(Util::getReportDate(), $region);
        if (!$currentQuarter) {
            return $query;
        }

        $lastQuarter = Quarter::getQuarterByDate($currentQuarter->getQuarterStartDate(), $region);
        if (!$lastQuarter) {
            return $query;
        }

        return $query->whereQuarterId($lastQuarter->id);
    }

    public function center()
    {
        return $this->belongsTo('TmlpStats\Center');
    }

    public function quarter()
    {
        return $this->belongsTo('TmlpStats\Quarter');
    }

    public function user()
    {
        return $this->belongsTo('TmlpStats\User');
    }

    public function globalReports()
    {
        return $this->belongsToMany('TmlpStats\GlobalReport', 'global_report_stats_report')->withTimestamps();
    }

    public function courseData()
    {
        return $this->hasMany('TmlpStats\CourseData');
    }

    public function teamMemberData()
    {
        return $this->hasMany('TmlpStats\TeamMemberData');
    }

    public function teamRegistrationData()
    {
        return $this->hasMany('TmlpStats\TeamRegistrationData');
    }

    public function centerStatsData()
    {
        return $this->hasMany('TmlpStats\CenterStatsData');
    }

    public function tmlpGamesData()
    {
        return $this->hasMany('TmlpStats\TmlpGamesData');
    }
}
