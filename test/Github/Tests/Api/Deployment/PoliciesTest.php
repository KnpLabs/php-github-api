<?php

namespace Github\Tests\Api\Deployment;

use Github\Tests\Api\TestCase;

class PoliciesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreatePolicy()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/environments/production/deployment-branch-policies');

        $api->create('KnpLabs', 'php-github-api', 'production', [
            'name' => 'name',
        ]);
    }

    /**
     * @test
     */
    public function shouldUpdatePolicy()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/environments/production/deployment-branch-policies/1');

        $api->update('KnpLabs', 'php-github-api', 'production', 1, [
            'name' => 'name',
        ]);
    }

    /**
     * @test
     */
    public function shouldGetAllPolicies()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/environments/production/deployment-branch-policies');

        $api->all('KnpLabs', 'php-github-api', 'production');
    }

    /**
     * @test
     */
    public function shouldShowPolicy()
    {
        $expectedValue = 'production';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/environments/production/deployment-branch-policies/1')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 'production', 1));
    }

    /**
     * @test
     */
    public function shouldDeletePolicy()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/environments/production/deployment-branch-policies/1')
            ->will($this->returnValue(null));

        $this->assertNull($api->remove('KnpLabs', 'php-github-api', 'production', 1));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Deployment\Policies::class;
    }
}
