<?php

namespace TmlpStats\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use TmlpStats\Center;
use TmlpStats\GlobalReport;
use TmlpStats\Http\Requests;
use TmlpStats\StatsReport;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $center = Center::find($id);
        if (!$center) {
            return '<p>Center not found.</p>';
        }

        $roster = $center->getTeamRoster();

        $latestReport = StatsReport::byCenter($center)
            ->orderBy('reporting_date', 'desc')
            ->first();

        $statsReportsThisWeek = StatsReport::byCenter($center)
            ->reportingDate($latestReport->reportingDate)
            ->get();
        $reportsThisWeek = [];
        foreach ($statsReportsThisWeek as $report) {
            $reportsThisWeek[$report->id] = $report->reportingDate->format('M d, Y');
        }

        return view('centers.show')->with(compact('roster', 'statsReportsThisWeek'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
