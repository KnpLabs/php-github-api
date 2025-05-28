<?php

namespace ArgoCD\Tests\Api\Organization;

use ArgoCD\Exception\MissingArgumentException;
use ArgoCD\Tests\Api\TestCase;

class TeamsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllOrganizationTeams()
    {
        $expectedValue = [['name' => 'KnpWorld'], ['name' => 'KnpFrance'], ['name' => 'KnpMontreal']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/teams')
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
            ->with('/orgs/KnpLabs/teams/KnpWorld/memberships/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->check('KnpWorld', 'l3l0', 'KnpLabs'));
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
            ->with('/orgs/KnpLabs/teams/KnpWorld')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpWorld', 'KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldShowOrganizationTeam()
    {
        $expectedValue = ['username' => 'l3l0'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/teams/KnpWorld')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpWorld', 'KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldGetTeamMembers()
    {
        $expectedValue = [['username' => 'l3l0']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/teams/KnpWorld/members')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->members('KnpWorld', 'KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldAddTeamMembers()
    {
        $expectedValue = ['username' => 'l3l0'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/orgs/KnpLabs/teams/KnpWorld/memberships/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->addMember('KnpWorld', 'l3l0', 'KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldRemoveTeamMembers()
    {
        $expectedValue = ['username' => 'l3l0'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/orgs/KnpLabs/teams/KnpWorld/memberships/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeMember('KnpWorld', 'l3l0', 'KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldGetTeamRepositories()
    {
        $expectedValue = [['name' => 'l3l0repo']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/teams/KnpWorld/repos')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->repositories('KnpWorld', 'KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldGetTeamRepositoriesViaLegacy()
    {
        $expectedValue = [['name' => 'l3l0repo']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/teams/KnpWorld/repos')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->repositories('KnpWorld'));
    }

    /**
     * @test
     */
    public function shouldGetTeamRepository()
    {
        $expectedValue = ['name' => 'l3l0repo'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/teams/KnpWorld/repos/l3l0/l3l0Repo')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->repository('KnpWorld', 'l3l0', 'l3l0Repo'));
    }

    /**
     * @test
     */
    public function shouldAddTeamRepository()
    {
        $expectedValue = ['name' => 'l3l0repo'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/orgs/l3l0/teams/KnpWorld/repos/l3l0/l3l0Repo')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->addRepository('KnpWorld', 'l3l0', 'l3l0Repo'));
    }

    /**
     * @test
     */
    public function shouldRemoveTeamRepository()
    {
        $expectedValue = ['name' => 'l3l0repo'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/orgs/l3l0/teams/KnpWorld/repos/l3l0/l3l0Repo')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeRepository('KnpWorld', 'l3l0', 'l3l0Repo'));
    }

    /**
     * @test
     */
    public function shouldNotCreateTeamWithoutName()
    {
        $this->expectException(MissingArgumentException::class);
        $data = [];

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
        $expectedValue = ['name' => 'KnpWorld'];
        $data = ['name' => 'KnpWorld'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/orgs/KnpLabs/teams', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', $data));
    }

    /**
     * @test
     */
    public function shouldCreateOrganizationTeamWithRepoName()
    {
        $expectedValue = ['name' => 'KnpWorld'];
        $data = ['name' => 'KnpWorld', 'repo_names' => 'somerepo'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/orgs/KnpLabs/teams', ['name' => 'KnpWorld', 'repo_names' => ['somerepo']])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', $data));
    }

    /**
     * @test
     */
    public function shouldCreateWithPullPermissionWhenPermissionParamNotRecognized()
    {
        $expectedValue = ['name' => 'KnpWorld'];
        $data = ['name' => 'KnpWorld', 'permission' => 'someinvalid'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/orgs/KnpLabs/teams', ['name' => 'KnpWorld', 'permission' => 'pull'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', $data));
    }

    /**
     * @test
     */
    public function shouldNotUpdateTeamWithoutName()
    {
        $this->expectException(MissingArgumentException::class);
        $data = [];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('patch');

        $api->update('KnpWorld', $data, 'KnpLabs');
    }

    /**
     * @test
     */
    public function shouldUpdateOrganizationTeam()
    {
        $expectedValue = ['name' => 'KnpWorld'];
        $data = ['name' => 'KnpWorld'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/orgs/KnpLabs/teams/KnpWorld', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpWorld', $data, 'KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldUpdateWithPullPermissionWhenPermissionParamNotRecognized()
    {
        $expectedValue = ['name' => 'KnpWorld'];
        $data = ['name' => 'KnpWorld', 'permission' => 'someinvalid'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/orgs/KnpLabs/teams/KnpWorld', ['name' => 'KnpWorld', 'permission' => 'pull'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpWorld', $data, 'KnpLabs'));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \ArgoCD\Api\Organization\Teams::class;
    }
}
