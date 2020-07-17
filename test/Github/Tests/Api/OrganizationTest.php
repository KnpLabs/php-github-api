<?php

namespace Github\Tests\Api;

class OrganizationTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllOrganizations()
    {
        $expectedValue = [['login' => 'KnpLabs']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/organizations?since=1')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all(1));
    }

    /**
     * @test
     */
    public function shouldShowOrganization()
    {
        $expectedArray = ['id' => 1, 'name' => 'KnpLabs'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldUpdateOrganization()
    {
        $expectedArray = ['id' => 1, 'name' => 'KnpLabs'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/orgs/KnpLabs', ['value' => 'toUpdate'])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update('KnpLabs', ['value' => 'toUpdate']));
    }

    /**
     * @test
     */
    public function shouldGetOrganizationRepositories()
    {
        $expectedArray = [['id' => 1, 'username' => 'KnpLabs', 'name' => 'php-github-api']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/repos', ['type' => 'all', 'page' => 1])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->repositories('KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldGetMembersApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Organization\Members::class, $api->members());
    }

    /**
     * @test
     */
    public function shouldGetTeamsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Organization\Teams::class, $api->teams());
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Organization::class;
    }
}
