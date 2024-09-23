<?php

namespace Github\Tests\Api\Copilot;

use Github\Api\Copilot\Usage;
use Github\Tests\Api\TestCase;

class UsageTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetOrgUsageSummary(): void
    {
        $expectedValue = ['usage1', 'usage2'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/copilot/usage', [])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->orgUsageSummary('KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldGetOrgTeamUsageSummary(): void
    {
        $expectedValue = ['usage1', 'usage2'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/team/php-github-api/copilot/usage', [])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->orgTeamUsageSummary('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetEnterpriseUsageSummary(): void
    {
        $expectedValue = ['usage1', 'usage2'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/enterprises/KnpLabs/copilot/usage', [])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->enterpriseUsageSummary('KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldGetEnterpriseTeamUsageSummary(): void
    {
        $expectedValue = ['usage1', 'usage2'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/enterprises/KnpLabs/team/php-github-api/copilot/usage', [])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->enterpriseTeamUsageSummary('KnpLabs', 'php-github-api'));
    }

    protected function getApiClass(): string
    {
        return Usage::class;
    }
}
