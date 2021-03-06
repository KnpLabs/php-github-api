<?php

namespace Github\Tests\Api\Repository\Actions;

use Github\Api\Repository\Actions\Workflows;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class WorkflowsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetWorkflows()
    {
        $expectedArray = [
            [
                'id' => 'id',
                'node_id' => 'node_id',
                'name' => 'CI',
                'path' => '.github/workflows/ci.yml',
                'state' => 'active',
                'created_at' => '2020-11-07T15:09:45.000Z',
                'updated_at' => '2020-11-07T15:09:45.000Z',
            ],
        ];

        /** @var Workflows|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/actions/workflows')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldShowWorkflow()
    {
        $expectedArray = [
            'id' => 'id',
            'node_id' => 'node_id',
            'name' => 'CI',
            'path' => '.github/workflows/ci.yml',
            'state' => 'active',
            'created_at' => '2020-11-07T15:09:45.000Z',
            'updated_at' => '2020-11-07T15:09:45.000Z',
        ];

        /** @var Workflows|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/actions/workflows/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('KnpLabs', 'php-github-api', 1));
    }

    /**
     * @test
     */
    public function shouldGetWorkflowUsage()
    {
        $expectedArray = [
            'billable' => [
                'UBUNTU' => ['total_ms' => 180000, 'jobs' => 1],
                'MACOS' => ['total_ms' => 240000, 'jobs' => 1],
                'WINDOWS' => ['total_ms' => 300000, 'jobs' => 1],
            ],
        ];

        /** @var Workflows|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/actions/workflows/1/timing')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->usage('KnpLabs', 'php-github-api', 1));
    }

    /**
     * @test
     */
    public function shouldDispatchWorkflow()
    {
        // empty
        $expectedArray = [];

        /** @var Workflows|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/actions/workflows/1/dispatches')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->dispatches('KnpLabs', 'php-github-api', 1, 'main'));
    }

    protected function getApiClass()
    {
        return Workflows::class;
    }
}
