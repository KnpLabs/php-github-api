<?php

namespace Github\Tests\Api\Organization;

use Github\Tests\Api\TestCase;

class TeamsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllOrganizationTeams()
    {
        $expectedValue = array(array('name' => 'KnpWorld'), array('name' => 'KnpFrance'), array('name' => 'KnpMontreal'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('orgs/KnpLabs/teams')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldCheckIfMemberIsInOrganizationTeam()
    {
        $expectedValue = 'response';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('teams/KnpWorld/members/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->check('KnpWorld', 'l3l0'));
    }

    /**
     * @test
     */
    public function shouldRemoveOrganizationTeam()
    {
        $expectedValue = 'response';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('teams/KnpWorld')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpWorld'));
    }

    /**
     * @test
     */
    public function shouldShowOrganizationTeam()
    {
        $expectedValue = array('username' => 'l3l0');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('teams/KnpWorld')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpWorld'));
    }

    /**
     * @test
     */
    public function shouldGetTeamMembers()
    {
        $expectedValue = array(array('username' => 'l3l0'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('teams/KnpWorld/members')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->members('KnpWorld'));
    }

    /**
     * @test
     */
    public function shouldAddTeamMembers()
    {
        $expectedValue = array('username' => 'l3l0');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('teams/KnpWorld/members/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->addMember('KnpWorld', 'l3l0'));
    }

    /**
     * @test
     */
    public function shouldRemoveTeamMembers()
    {
        $expectedValue = array('username' => 'l3l0');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('teams/KnpWorld/members/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeMember('KnpWorld', 'l3l0'));
    }

    /**
     * @test
     */
    public function shouldGetTeamRepositories()
    {
        $expectedValue = array(array('name' => 'l3l0repo'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('teams/KnpWorld/repos')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->repositories('KnpWorld'));
    }

    /**
     * @test
     */
    public function shouldGetTeamRepository()
    {
        $expectedValue = array('name' => 'l3l0repo');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('teams/KnpWorld/repos/l3l0/l3l0Repo')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->repository('KnpWorld', 'l3l0', 'l3l0Repo'));
    }

    /**
     * @test
     */
    public function shouldAddTeamRepository()
    {
        $expectedValue = array('name' => 'l3l0repo');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('teams/KnpWorld/repos/l3l0/l3l0Repo')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->addRepository('KnpWorld', 'l3l0', 'l3l0Repo'));
    }

    /**
     * @test
     */
    public function shouldRemoveTeamRepository()
    {
        $expectedValue = array('name' => 'l3l0repo');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('teams/KnpWorld/repos/l3l0/l3l0Repo')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeRepository('KnpWorld', 'l3l0', 'l3l0Repo'));
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTeamWithoutName()
    {
        $data = array();

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', $data);
    }

    /**
     * @test
     */
    public function shouldCreateOrganizationTeam()
    {
        $expectedValue = array('name' => 'KnpWorld');
        $data = array('name' => 'KnpWorld');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('orgs/KnpLabs/teams', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', $data));
    }

    /**
     * @test
     */
    public function shouldCreateOrganizationTeamWithRepoName()
    {
        $expectedValue = array('name' => 'KnpWorld');
        $data = array('name' => 'KnpWorld', 'repo_names' => 'somerepo');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('orgs/KnpLabs/teams', array('name' => 'KnpWorld', 'repo_names' => array('somerepo')))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', $data));
    }

    /**
     * @test
     */
    public function shouldCreateWithPullPermissionWhenPermissionParamNotRecognized()
    {
        $expectedValue = array('name' => 'KnpWorld');
        $data = array('name' => 'KnpWorld', 'permission' => 'someinvalid');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('orgs/KnpLabs/teams', array('name' => 'KnpWorld', 'permission' => 'pull'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', $data));
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotUpdateTeamWithoutName()
    {
        $data = array();

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('patch');

        $api->update('KnpWorld', $data);
    }

    /**
     * @test
     */
    public function shouldUpdateOrganizationTeam()
    {
        $expectedValue = array('name' => 'KnpWorld');
        $data = array('name' => 'KnpWorld');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('teams/KnpWorld', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpWorld', $data));
    }

    /**
     * @test
     */
    public function shouldUpdateWithPullPermissionWhenPermissionParamNotRecognized()
    {
        $expectedValue = array('name' => 'KnpWorld');
        $data = array('name' => 'KnpWorld', 'permission' => 'someinvalid');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('teams/KnpWorld', array('name' => 'KnpWorld', 'permission' => 'pull'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpWorld', $data));
    }

    protected function getApiClass()
    {
        return 'Github\Api\Organization\Teams';
    }
}
