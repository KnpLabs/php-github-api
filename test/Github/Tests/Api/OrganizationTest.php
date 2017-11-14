<?php declare(strict_types=1);

namespace Github\Tests\Api;

class OrganizationTest extends TestCase
{
    public function shouldGetAllOrganizations()
    {
        $expectedValue = array(array('login' => 'KnpLabs'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/organizations?since=1')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all(1));
    }

    public function shouldShowOrganization()
    {
        $expectedArray = array('id' => 1, 'name' => 'KnpLabs');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('KnpLabs'));
    }

    public function shouldUpdateOrganization()
    {
        $expectedArray = array('id' => 1, 'name' => 'KnpLabs');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/orgs/KnpLabs', array('value' => 'toUpdate'))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update('KnpLabs', array('value' => 'toUpdate')));
    }

    public function shouldGetOrganizationRepositories()
    {
        $expectedArray = array(array('id' => 1, 'username' => 'KnpLabs', 'name' => 'php-github-api'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/repos', array('type' => 'all', 'page' => 1))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->repositories('KnpLabs'));
    }

    public function shouldGetMembersApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Organization\Members::class, $api->members());
    }

    public function shouldGetTeamsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Organization\Teams::class, $api->teams());
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\Organization::class;
    }
}
