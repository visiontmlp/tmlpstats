<?php
namespace TmlpStats\Tests\Unit\Api;

use App;
use Carbon\Carbon;
use TmlpStats as Models;
use TmlpStats\Api;
use TmlpStats\Domain;
use TmlpStats\Tests\Mocks\MockContext;
use TmlpStats\Tests\TestAbstract;

class SubmissionCoreTest extends TestAbstract
{
    protected $instantiateApp = true;
    protected $testClass = Api\SubmissionCore::class;

    public function setUp()
    {
        parent::setUp();

        $reportingDateStr = '2016-04-15';
        $this->reportingDate = Carbon::parse($reportingDateStr);

        $center = $this->center = new Models\Center(['id' => 123]);
        $center->setRelation('region', new Models\Region(['id' => 123]));

        $this->context = MockContext::defaults()->withCenter($this->center)->install();
    }

    public function testBlah()
    {
        $this->providerProgramLeaderAttending();
    }

    /**
     * @dataProvider providerProgramLeaderAttending
     */
    public function testCalculateProgramLeaderAttending($input, $expected)
    {
        $this->context->withFakedAdmin()->install();

        $fakeProgramLeaders = new FakeProgramLeaderApi($this->context);
        foreach ($input as $k => $v) {
            if ($k != 'meta') {
                $input[$k] = Domain\ProgramLeader::fromArray($v);
            }
        }
        $fakeProgramLeaders->mockData = $input;

        App::instance(Api\Submission\ProgramLeader::class, $fakeProgramLeaders);

        $api = App::make(Api\SubmissionCore::class);

        list($pm, $cl) = $api->calculateProgramLeaderAttending($this->center, $this->reportingDate);
        if (is_null($expected[0])) {
            $this->assertNull($pm);
        } else {
            $this->assertEquals($expected[0], $pm);
        }
        if (is_null($expected[1])) {
            $this->assertNull($cl);
        } else {
            $this->assertEquals($expected[1], $cl);
        }
    }

    public function providerProgramLeaderAttending()
    {

        return [
            // Standard case: two people, both attending weekend
            [
                [
                    'meta' => [
                        'programManager' => 1,
                        'classroomLeader' => 2,
                    ],
                    1 => ['attendingWeekend' => true],
                    2 => ['attendingWeekend' => true],
                ],
                [1, 1],

            ],

            // PM/CL is a single person, attending weekend
            [
                [
                    'meta' => [
                        'programManager' => 1,
                        'classroomLeader' => 1,
                    ],
                    1 => ['attendingWeekend' => true],
                ],
                [1, null],

            ],

            // PM/CL is a single person, NOT attending weekend
            [
                [
                    'meta' => [
                        'programManager' => 1,
                        'classroomLeader' => 1,
                    ],
                    1 => ['attendingWeekend' => false],
                ],
                [0, 0],

            ],

            // No PM/CL is set
            [
                [
                    'meta' => [
                        'programManager' => null,
                        'classroomLeader' => null,
                    ],
                ],
                [null, null],
            ],

            // Only CL is set
            [
                [
                    'meta' => [
                        'programManager' => null,
                        'classroomLeader' => 1,
                    ],
                    1 => ['attendingWeekend' => true],

                ],
                [null, 1],
            ],
        ];
    }
}

class FakeProgramLeaderApi extends Api\Submission\ProgramLeader
{
    public $mockData;
    public function allForCenter(Models\Center $a, Carbon $b, $c = false)
    {

        return $this->mockData;
    }
}
