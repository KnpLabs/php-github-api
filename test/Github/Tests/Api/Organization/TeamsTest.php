<?php declare(strict_types=1);

namespace Github\Tests\Api\Organization;

use Github\Tests\Api\TestCase;

class TeamsTest extends TestCase
{
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

    public function shouldCheckIfMemberIsInOrganizationTeam()
    {
        $expectedValue = 'response';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/teams/KnpWorld/memberships/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->check('KnpWorld', 'l3l0'));
    }

    public function shouldRemoveOrganizationTeam()
    {
        $expectedValue = 'response';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/teams/KnpWorld')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpWorld'));
    }

    public function shouldShowOrganizationTeam()
    {
        $expectedValue = ['username' => 'l3l0'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/teams/KnpWorld')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpWorld'));
    }

    public function shouldGetTeamMembers()
    {
        $expectedValue = [['username' => 'l3l0']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/teams/KnpWorld/members')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->members('KnpWorld'));
    }

    public function shouldAddTeamMembers()
    {
        $expectedValue = ['username' => 'l3l0'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/teams/KnpWorld/memberships/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->addMember('KnpWorld', 'l3l0'));
    }

    public function shouldRemoveTeamMembers()
    {
        $expectedValue = ['username' => 'l3l0'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/teams/KnpWorld/memberships/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeMember('KnpWorld', 'l3l0'));
    }

    public function shouldGetTeamRepositories()
    {
        $expectedValue = [['name' => 'l3l0repo']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/teams/KnpWorld/repos')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->repositories('KnpWorld'));
    }

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

    public function shouldAddTeamRepository()
    {
        $expectedValue = ['name' => 'l3l0repo'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/teams/KnpWorld/repos/l3l0/l3l0Repo')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->addRepository('KnpWorld', 'l3l0', 'l3l0Repo'));
    }

    public function shouldRemoveTeamRepository()
    {
        $expectedValue = ['name' => 'l3l0repo'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/teams/KnpWorld/repos/l3l0/l3l0Repo')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeRepository('KnpWorld', 'l3l0', 'l3l0Repo'));
    }

    public function shouldNotCreateTeamWithoutName()
    {
        $data = [];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', $data);
    }

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

    public function shouldNotUpdateTeamWithoutName()
    {
        $data = [];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('patch');

        $api->update('KnpWorld', $data);
    }

    public function shouldUpdateOrganizationTeam()
    {
        $expectedValue = ['name' => 'KnpWorld'];
        $data = ['name' => 'KnpWorld'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/teams/KnpWorld', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpWorld', $data));
    }

    public function shouldUpdateWithPullPermissionWhenPermissionParamNotRecognized()
    {
        $expectedValue = ['name' => 'KnpWorld'];
        $data = ['name' => 'KnpWorld', 'permission' => 'someinvalid'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/teams/KnpWorld', ['name' => 'KnpWorld', 'permission' => 'pull'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpWorld', $data));
    }

    protected function getApiClass(): string
    {
        return \Github\Api\Organization\Teams::class;
    }
}
