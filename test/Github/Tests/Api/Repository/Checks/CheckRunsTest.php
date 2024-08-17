<?php

namespace Github\Tests\Api\Repository\Checks;

use Github\Api\Repository\Checks\CheckRuns;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CheckRunsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateCheck()
    {
        $expectedValue = ['state' => 'success'];
        $data = ['head_sha' => 'commitSHA123456', 'name' => 'my check'];

        /** @var CheckRuns|MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/check-runs', $data)
            ->willReturn($expectedValue);

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldShowSingleCheckRun()
    {
        /** @var CheckRuns|MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/check-runs/14');

        $api->show('KnpLabs', 'php-github-api', 14);
    }

    /**
     * @test
     */
    public function shouldUpdateCheck()
    {
        $expectedValue = ['state' => 'success'];
        $data = ['head_sha' => 'commitSHA123456', 'name' => 'my check'];

        /** @var CheckRuns|MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/check-runs/123', $data)
            ->willReturn($expectedValue);

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 123, $data));
    }

    /**
     * @test
     */
    public function shouldListCheckRunAnnotations()
    {
        /** @var CheckRuns|MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/check-runs/14/annotations');

        $api->annotations('KnpLabs', 'php-github-api', 14);
    }

    /**
     * @test
     */
    public function shouldGetAllChecksForCheckSuite()
    {
        $params = ['test' => true];
        /** @var CheckRuns|MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/check-suites/123/check-runs', $params);

        $api->allForCheckSuite('KnpLabs', 'php-github-api', 123, $params);
    }

    /**
     * @test
     */
    public function shouldGetAllChecksForReference()
    {
        $params = ['test' => true];
        /** @var CheckRuns|MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/commits/cb4abc15424c0015b4468d73df55efb8b60a4a3d/check-runs', $params);

        $api->allForReference('KnpLabs', 'php-github-api', 'cb4abc15424c0015b4468d73df55efb8b60a4a3d', $params);
    }

    /**
     * @test
     */
    public function shouldRerequestCheckRun()
    {
        /** @var CheckRuns|MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/check-runs/123/rerequest');

        $api->rerequest('KnpLabs', 'php-github-api', 123);
    }

    protected function getApiClass(): string
    {
        return CheckRuns::class;
    }
}
