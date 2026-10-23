<?php

namespace Github\Api\Organization;

use Github\Api\AbstractApi;

/**
 * @link   https://docs.github.com/rest/orgs/organization-roles
 */
class OrganizationRoles extends AbstractApi
{
    /**
     * List all the organization roles available in the organization.
     *
     * @link https://docs.github.com/rest/orgs/organization-roles#get-all-organization-roles-for-an-organization
     *
     * @param string $organization the organization
     *
     * @return array
     */
    public function all(string $organization)
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/organization-roles');
    }

    /**
     * Get an organization role by its ID.
     *
     * @link https://docs.github.com/rest/orgs/organization-roles#get-an-organization-role
     *
     * @param string $organization the organization
     * @param int    $roleId       the ID of the role to get
     *
     * @return array
     */
    public function show(string $organization, int $roleId)
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/organization-roles/'.$roleId);
    }

    /**
     * List the teams that are assigned to an organization role.
     *
     * @link https://docs.github.com/rest/orgs/organization-roles#list-teams-that-are-assigned-to-an-organization-role
     *
     * @param string $organization the organization
     * @param int    $roleId       the ID of the role
     *
     * @return array
     */
    public function listTeamsWithRole(string $organization, int $roleId)
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/organization-roles/'.$roleId.'/teams');
    }

    /**
     * Assign an organization role to a team.
     *
     * @link https://docs.github.com/rest/orgs/organization-roles#assign-an-organization-role-to-a-team
     *
     * @param string $organization the organization
     * @param int    $roleId       the ID of the role to assign
     * @param string $teamSlug     the slug of the team
     */
    public function assignRoleToTeam(string $organization, int $roleId, string $teamSlug): void
    {
        $this->put('/orgs/'.rawurlencode($organization).'/organization-roles/teams/'.rawurlencode($teamSlug).'/'.$roleId);
    }

    /**
     * Remove an organization role from a team.
     *
     * @link https://docs.github.com/rest/orgs/organization-roles#remove-an-organization-role-from-a-team
     *
     * @param string $organization the organization
     * @param int    $roleId       the ID of the role to remove
     * @param string $teamSlug     the slug of the team
     */
    public function removeRoleFromTeam(string $organization, int $roleId, string $teamSlug): void
    {
        $this->delete('/orgs/'.rawurlencode($organization).'/organization-roles/teams/'.rawurlencode($teamSlug).'/'.$roleId);
    }

    /**
     * Remove all assigned organization roles from a team.
     *
     * @link https://docs.github.com/rest/orgs/organization-roles#remove-all-organization-roles-for-a-team
     *
     * @param string $organization the organization
     * @param string $teamSlug     the slug of the team
     */
    public function removeAllRolesFromTeam(string $organization, string $teamSlug): void
    {
        $this->delete('/orgs/'.rawurlencode($organization).'/organization-roles/teams/'.rawurlencode($teamSlug));
    }

    /**
     * List the users that are assigned to an organization role.
     *
     * @link https://docs.github.com/rest/orgs/organization-roles#list-users-that-are-assigned-to-an-organization-role
     *
     * @param string $organization the organization
     * @param int    $roleId       the ID of the role
     *
     * @return array
     */
    public function listUsersWithRole(string $organization, int $roleId): array
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/organization-roles/'.$roleId.'/users');
    }

    /**
     * Assign an organization role to a user.
     *
     * @link https://docs.github.com/rest/orgs/organization-roles#assign-an-organization-role-to-a-user
     *
     * @param string $organization the organization
     * @param int    $roleId       the ID of the role to assign
     * @param string $username     the username
     */
    public function assignRoleToUser(string $organization, int $roleId, string $username): void
    {
        $this->put('/orgs/'.rawurlencode($organization).'/organization-roles/users/'.rawurlencode($username).'/'.$roleId);
    }

    /**
     * Remove an organization role from a user.
     *
     * @link https://docs.github.com/rest/orgs/organization-roles#remove-an-organization-role-from-a-user
     *
     * @param string $organization the organization
     * @param int    $roleId       the ID of the role to remove
     * @param string $username     the username
     */
    public function removeRoleFromUser(string $organization, int $roleId, string $username): void
    {
        $this->delete('/orgs/'.rawurlencode($organization).'/organization-roles/users/'.rawurlencode($username).'/'.$roleId);
    }

    /**
     * Remove all assigned organization roles from a user.
     *
     * @link https://docs.github.com/rest/orgs/organization-roles#remove-all-organization-roles-for-a-user
     *
     * @param string $organization the organization
     * @param string $username     the username
     */
    public function removeAllRolesFromUser(string $organization, string $username): void
    {
        $this->delete('/orgs/'.rawurlencode($organization).'/organization-roles/users/'.rawurlencode($username));
    }
}
