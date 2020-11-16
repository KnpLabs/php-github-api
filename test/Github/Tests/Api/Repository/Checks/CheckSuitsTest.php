<?php

namespace Github\Tests\Api\Repository\Checks;

use Github\Api\Repository\Checks\CheckSuites;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CheckSuitsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateCheckSuite()
    {
        $expectedValue = ['state' => 'success'];
        $data = ['head_sha' => 'commitSHA123456', 'name' => 'my check'];

        /** @var CheckSuites|MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/check-suites', $data)
            ->willReturn($expectedValue);

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldUpdateCheckSuitePreferences()
    {
        $expectedValue = ['preferences' => []];
        $data = ['preference_1' => true];

        /** @var CheckSuites|MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/check-suites/preferences', $data)
            ->willReturn($expectedValue);

        $this->assertEquals($expectedValue, $api->updatePreferences('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldGetCheckSuite()
    {
        /** @var CheckSuites|MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/check-suites/14');

        $api->getCheckSuite('KnpLabs', 'php-github-api', 14);
    }

    /**
     * @test
     */
    public function shouldRerequest()
    {
        /** @var CheckSuites|MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/check-suites/14/rerequest');

        $api->rerequest('KnpLabs', 'php-github-api', 14);
    }

    /**
     * @test
     */
    public function shouldGetAllCheckSuitesForReference()
    {
        /** @var CheckSuites|MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/commits/cb4abc15424c0015b4468d73df55efb8b60a4a3d/check-suites');

        $api->allForReference('KnpLabs', 'php-github-api', 'cb4abc15424c0015b4468d73df55efb8b60a4a3d');
    }

    protected function getApiClass(): string
    {
        return CheckSuites::class;
    }
}
