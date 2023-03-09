<?php

namespace Github\Tests\Api;

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
            ->with('/repos/KnpLabs/php-github-api/environments');

        $api->create('KnpLabs', 'php-github-api');
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
        $expectedValue = ['name' => 123];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/environments/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     */
    public function shouldDeleteEnvironment()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/environments/123')
            ->will($this->returnValue(null));

        $this->assertNull($api->remove('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Environment::class;
    }
}
