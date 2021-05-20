<?php

namespace Github\Tests\Api\Repository\Actions;

use Github\Api\Repository\Actions\WorkflowRuns;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class WorkflowRunsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllWorkflowRuns()
    {
        $expectedArray = [
            [
                'id' => 'id',
                'event' => 'push',
                'status' => 'queued',
            ],
        ];

        /** @var WorkflowRuns|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/actions/runs')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetWorkflowRuns()
    {
        $expectedArray = [
            [
                'id' => 'id',
                'name' => 'CI',
                'event' => 'push',
                'status' => 'completed',
                'conclusion' => 'success',
                'workflow_id' => 3441570,
            ],
        ];

        /** @var WorkflowRuns|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/actions/workflows/3441570/runs')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->listRuns('KnpLabs', 'php-github-api', 3441570));
    }

    /**
     * @test
     */
    public function shouldShowWorkflowRun()
    {
        $expectedArray = ['id' => 'id', 'name' => 'CI'];

        /** @var WorkflowRuns|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/actions/runs/374473304')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('KnpLabs', 'php-github-api', 374473304));
    }

    /**
     * @test
     */
    public function shouldDeleteWorkflowRun()
    {
        $expectedValue = 'response';

        /** @var WorkflowRuns|MockObject $api */
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/actions/runs/374473304')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 374473304));
    }

    /**
     * @test
     */
    public function shouldGetWorkflowRunUsage()
    {
        $expectedArray = [
            'billable' => [
                'UBUNTU' => ['total_ms' => 180000, 'jobs' => 1],
                'MACOS' => ['total_ms' => 240000, 'jobs' => 1],
                'WINDOWS' => ['total_ms' => 300000, 'jobs' => 1],
            ],
            'run_duration_ms' => 500000,
        ];

        /** @var WorkflowRuns|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/actions/runs/374473304/timing')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->usage('KnpLabs', 'php-github-api', 374473304));
    }

    /**
     * @test
     */
    public function shouldRerunWorkflowRun()
    {
        $expectedValue = 'response';

        /** @var WorkflowRuns|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/actions/runs/374473304/rerun')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->rerun('KnpLabs', 'php-github-api', 374473304));
    }

    /**
     * @test
     */
    public function shouldCancelWorkflowRun()
    {
        $expectedValue = 'response';

        /** @var WorkflowRuns|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/actions/runs/374473304/cancel')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->cancel('KnpLabs', 'php-github-api', 374473304));
    }

    /**
     * @test
     */
    public function shouldDownloadWorkflowRunLogs()
    {
        $expectedValue = 'response';

        /** @var WorkflowRuns|MockObject $api */
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/actions/runs/374473304/logs')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->downloadLogs('KnpLabs', 'php-github-api', 374473304));
    }

    /**
     * @test
     */
    public function shouldDeleteWorkflowRunLogs()
    {
        $expectedValue = 'response';

        /** @var WorkflowRuns|MockObject $api */
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/actions/runs/374473304/logs')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->deleteLogs('KnpLabs', 'php-github-api', 374473304));
    }

    /**
     * @test
     */
    public function shouldApproveWorkflowRunLogs()
    {
        $expectedValue = 'response';

        /** @var WorkflowRuns|MockObject $api */
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/actions/runs/374473304/approve')
            ->will($this->returnValue($expectedValue));

        $this->assertSame($expectedValue, $api->approve('KnpLabs', 'php-github-api', 374473304));
    }

    protected function getApiClass()
    {
        return WorkflowRuns::class;
    }
}
