<?php

namespace Github\Tests\Api\Deployment;

use Github\Tests\Api\TestCase;

class EnvironmentTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateOrUpdateEnvironment()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/environments/production');

        $api->createOrUpdate('KnpLabs', 'php-github-api', 'production');
    }

    /**
     * @test
     */
    public function shouldGetAllEnvironments()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/environments');

        $api->all('KnpLabs', 'php-github-api');
    }

    /**
     * @test
     */
    public function shouldShowEnvironment()
    {
        $expectedValue = 'production';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/environments/production')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 'production'));
    }

    /**
     * @test
     */
    public function shouldDeleteEnvironment()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/environments/production')
            ->will($this->returnValue(null));

        $this->assertNull($api->remove('KnpLabs', 'php-github-api', 'production'));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Deployment\Environments::class;
    }
}
