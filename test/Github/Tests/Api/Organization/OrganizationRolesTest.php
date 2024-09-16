<?php

declare(strict_types=1);

namespace Github\Tests\Api\Organization;

use Github\Api\Organization\OrganizationRoles;
use Github\Tests\Api\TestCase;

class OrganizationRolesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllOrganizationRoles()
    {
        $expectedValue = [
            'total_count' => 1,
            'roles' => [[
                'id' => 1,
                'name' => 'all_repo_admin',
                'description' => 'Grants admin access to all repositories in the organization.',
                'permissions' => [],
                'organization' => null,
                'created_at' => '2023-01-01T00:00:00Z',
                'updated_at' => '2023-01-01T00:00:00Z',
                'source' => 'Predefined',
                'base_role' => 'admin',
            ]],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/orgs/acme/organization-roles')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('acme'));
    }

    /**
     * @test
     */
    public function shouldShowSingleOrganizationRole()
    {
        $expectedValue = [
            'id' => 1,
            'name' => 'all_repo_admin',
            'description' => 'Grants admin access to all repositories in the organization.',
            'permissions' => [],
            'organization' => null,
            'created_at' => '2023-01-01T00:00:00Z',
            'updated_at' => '2023-01-01T00:00:00Z',
            'source' => 'Predefined',
            'base_role' => 'admin',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/orgs/acme/organization-roles/1')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('acme', 1));
    }

    /**
     * @test
     */
    public function shouldGetAllTeamsWithRole()
    {
        $expectedValue = [['name' => 'Acme Admins']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/orgs/acme/organization-roles/1/teams')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->listTeamsWithRole('acme', 1));
    }

    /**
     * @test
     */
    public function shouldAssignRoleToTeam()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/orgs/acme/organization-roles/teams/acme-admins/1')
            ->will($this->returnValue(''));

        $api->assignRoleToTeam('acme', 1, 'acme-admins');
    }

    /**
     * @test
     */
    public function shouldRemoveRoleFromTeam()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/orgs/acme/organization-roles/teams/acme-admins/1')
            ->will($this->returnValue(''));

        $api->removeRoleFromTeam('acme', 1, 'acme-admins');
    }

    /**
     * @test
     */
    public function shouldRemoveAllRolesFromTeam()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/orgs/acme/organization-roles/teams/acme-admins')
            ->will($this->returnValue(''));

        $api->removeAllRolesFromTeam('acme', 'acme-admins');
    }

    /**
     * @test
     */
    public function shouldGetAllUsersWithRole()
    {
        $expectedValue = [['username' => 'Admin']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/orgs/acme/organization-roles/1/users')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->listUsersWithRole('acme', 1));
    }

    /**
     * @test
     */
    public function shouldAssignRoleToUser()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/orgs/acme/organization-roles/users/admin/1')
            ->will($this->returnValue(''));

        $api->assignRoleToUser('acme', 1, 'admin');
    }

    /**
     * @test
     */
    public function shouldRemoveRoleFromUser()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/orgs/acme/organization-roles/users/admin/1')
            ->will($this->returnValue(''));

        $api->removeRoleFromUser('acme', 1, 'admin');
    }

    /**
     * @test
     */
    public function shouldRemoveAllRolesFromUser()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/orgs/acme/organization-roles/users/admin')
            ->will($this->returnValue(''));

        $api->removeAllRolesFromUser('acme', 'admin');
    }

    protected function getApiClass(): string
    {
        return OrganizationRoles::class;
    }
}
