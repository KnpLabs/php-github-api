<?php

namespace Github\Tests\Api;

class OrganizationTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowOrganization()
    {
        $expectedArray = array('id' => 1, 'name' => 'KnpLabs');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('orgs/KnpLabs')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldUpdateOrganization()
    {
        $expectedArray = array('id' => 1, 'name' => 'KnpLabs');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('orgs/KnpLabs', array('value' => 'toUpdate'))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update('KnpLabs', array('value' => 'toUpdate')));
    }

    /**
     * @test
     */
    public function shouldGetOrganizationRepositories()
    {
        $expectedArray = array(array('id' => 1, 'username' => 'KnpLabs', 'name' => 'php-github-api'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('orgs/KnpLabs/repos', array('type' => 'all'))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->repositories('KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldGetMembersApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Organization\Members', $api->members());
    }

    /**
     * @test
     */
    public function shouldGetTeamsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Organization\Teams', $api->teams());
    }

    protected function getApiClass()
    {
        return 'Github\Api\Organization';
    }
}
