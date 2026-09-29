<?php

namespace Github\Api\Organization;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   https://docs.github.com/rest/teams/teams
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Teams extends AbstractApi
{
    /**
     * List all teams in an organization.
     *
     * @link https://docs.github.com/rest/teams/teams#list-teams
     *
     * @param string $organization the organization
     *
     * @return array
     */
    public function all($organization)
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/teams');
    }

    /**
     * Create a new team in an organization.
     *
     * @link https://docs.github.com/rest/teams/teams#create-a-team
     *
     * @param string $organization the organization
     * @param array  $params       the parameters (name is required)
     *
     * @throws \Github\Exception\MissingArgumentException
     *
     * @return array
     */
    public function create($organization, array $params)
    {
        if (!isset($params['name'])) {
            throw new MissingArgumentException('name');
        }
        if (isset($params['repo_names']) && !is_array($params['repo_names'])) {
            $params['repo_names'] = [$params['repo_names']];
        }
        if (isset($params['permission']) && !in_array($params['permission'], ['pull', 'push', 'admin'])) {
            $params['permission'] = 'pull';
        }

        return $this->post('/orgs/'.rawurlencode($organization).'/teams', $params);
    }

    /**
     * Get a team using the team's slug.
     *
     * @link https://docs.github.com/rest/teams/teams#get-a-team-by-name
     */
    public function show($team, $organization)
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/teams/'.rawurlencode($team));
    }

    /**
     * Edit a team.
     *
     * @link https://docs.github.com/rest/teams/teams#update-a-team
     */
    public function update($team, array $params, $organization)
    {
        if (!isset($params['name'])) {
            throw new MissingArgumentException('name');
        }
        if (isset($params['permission']) && !in_array($params['permission'], ['pull', 'push', 'admin'])) {
            $params['permission'] = 'pull';
        }

        return $this->patch('/orgs/'.rawurlencode($organization).'/teams/'.rawurlencode($team), $params);
    }

    /**
     * Delete a team.
     *
     * @link https://docs.github.com/rest/teams/teams#delete-a-team
     */
    public function remove($team, $organization)
    {
        return $this->delete('/orgs/'.rawurlencode($organization).'/teams/'.rawurlencode($team));
    }

    /**
     * List a team's members.
     *
     * @link https://docs.github.com/rest/teams/members#list-team-members
     */
    public function members($team, $organization)
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/teams/'.rawurlencode($team).'/members');
    }

    /**
     * Get team membership for a user.
     *
     * @link https://docs.github.com/rest/teams/members#get-team-membership-for-a-user
     */
    public function check($team, $username, $organization)
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/teams/'.rawurlencode($team).'/memberships/'.rawurlencode($username));
    }

    /**
     * Add or update team membership for a user.
     *
     * @link https://docs.github.com/rest/teams/members#add-or-update-team-membership-for-a-user
     */
    public function addMember($team, $username, $organization)
    {
        return $this->put('/orgs/'.rawurlencode($organization).'/teams/'.rawurlencode($team).'/memberships/'.rawurlencode($username));
    }

    /**
     * Remove team membership for a user.
     *
     * @link https://docs.github.com/rest/teams/members#remove-team-membership-for-a-user
     */
    public function removeMember($team, $username, $organization)
    {
        return $this->delete('/orgs/'.rawurlencode($organization).'/teams/'.rawurlencode($team).'/memberships/'.rawurlencode($username));
    }

    /**
     * @link https://docs.github.com/rest/teams/teams#list-team-repositories
     */
    public function repositories($team, $organization = '')
    {
        if (empty($organization)) {
            return $this->get('/teams/'.rawurlencode($team).'/repos');
        }

        return $this->get('/orgs/'.rawurlencode($organization).'/teams/'.rawurlencode($team).'/repos');
    }

    /**
     * Check team permissions for a repository.
     *
     * @link https://docs.github.com/rest/teams/teams#check-team-permissions-for-a-repository
     */
    public function repository($team, $organization, $repository)
    {
        return $this->get('/teams/'.rawurlencode($team).'/repos/'.rawurlencode($organization).'/'.rawurlencode($repository));
    }

    /**
     * Add or update team repository permissions.
     *
     * @link https://docs.github.com/rest/teams/teams#add-or-update-team-repository-permissions
     */
    public function addRepository($team, $organization, $repository, $params = [])
    {
        if (isset($params['permission']) && !in_array($params['permission'], ['pull', 'push', 'admin', 'maintain', 'triage'])) {
            $params['permission'] = 'pull';
        }

        return $this->put('/orgs/'.rawurlencode($organization).'/teams/'.rawurlencode($team).'/repos/'.rawurlencode($organization).'/'.rawurlencode($repository), $params);
    }

    /**
     * Remove a repository from a team.
     *
     * @link https://docs.github.com/rest/teams/teams#remove-a-repository-from-a-team
     */
    public function removeRepository($team, $organization, $repository)
    {
        return $this->delete('/orgs/'.rawurlencode($organization).'/teams/'.rawurlencode($team).'/repos/'.rawurlencode($organization).'/'.rawurlencode($repository));
    }
}
