<?php

namespace Github\Tests\Api\Repository\Actions;

use Github\Api\Repository\Actions\WorkflowJobs;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class WorkflowJobsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetWorkflowJobs()
    {
        $expectedArray = [
            ['id' => 'id', 'run_id' => 'run_id', 'status' => 'completed', 'conclusion' => 'success'],
        ];

        /** @var WorkflowJobs|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/actions/runs/1/jobs')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('KnpLabs', 'php-github-api', 1));
    }

    /**
     * @test
     */
    public function shouldShowWorkflowJob()
    {
        $expectedArray = [
            'id' => 'id', 'run_id' => 'run_id', 'status' => 'completed', 'conclusion' => 'success',
        ];

        /** @var WorkflowJobs|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/actions/jobs/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('KnpLabs', 'php-github-api', 1));
    }

    protected function getApiClass()
    {
        return WorkflowJobs::class;
    }
}
