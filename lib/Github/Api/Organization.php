<?php

namespace Github\Api;

/**
 * Searching organizations, getting organization information
 * and managing authenticated organization account information.
 *
 * @link      http://develop.github.com/p/orgs.html
 * @author    Antoine Berranger <antoine at ihqs dot net>
 * @license   MIT License
 */
class Organization extends Api
{
    const ADMIN = "admin";
    const PUSH = "push";
    const PULL = "pull";

    /**
     * Get extended information about an organization by its name
     * http://develop.github.com/p/orgs.html
     *
     * @param   string  $name             the organization to show
     * @return  array                     informations about the organization
     */
    public function show($name)
    {
        return $this->get('orgs/'.urlencode($name));
    }

    /**
     * List all repositories across all the organizations that you can access
     * http://develop.github.com/p/orgs.html
     *
     * @param   string  $name             the user name
     * @return  array                     the repositories
     */
    public function getAllRepos($name)
    {
        $response = $this->get('organizations/repositories');

        return $response['repositories'];
    }

    /**
     * List all public repositories of any other organization
     * http://develop.github.com/p/orgs.html
     *
     * @param   string  $name             the organization name
     * @return  array                     the repositories
     */
    public function getPublicRepos($name)
    {
        $response = $this->get('organizations/'.urlencode($name).'/public_repositories');

        return $response['repositories'];
    }

    /**
     * List all public members of that organization
     * @link http://developer.github.com/v3/orgs/members/
     *
     * @param   string  $name             the organization name
     * @return  array                     the members
     */
    public function getPublicMembers($name)
    {
        return $this->get('orgs/'.urlencode($name).'/members');
    }

    /**
     * Check that user is in that organization
     * @link http://developer.github.com/v3/orgs/members/
     *
     * @param   string  $name             the organization name
     * @param   string  $user             the user
     * @return  array                     the members
     */
    public function getPublicMember($name, $user)
    {
        return $this->get('orgs/'.urlencode($name).'/members/'.urlencode($user));
    }

    /**
     * List all teams of that organization
     * @link http://developer.github.com/v3/orgs/teams/
     *
     * @param   string  $name             the organization name
     * @return  array                     the teams
     */
    public function getTeams($name)
    {
        return $this->get('orgs/'.urlencode($name).'/teams');
    }

    /**
     * Get team with given id of that organization
     * @link http://developer.github.com/v3/orgs/teams/
     *
     * @param   string  $name             the organization name
     * @param   string  $id               id of team
     * @return  array                     the team
     */
    public function getTeam($name, $id)
    {
        return $this->get('orgs/'.urlencode($name).'/teams/'.urlencode($id));
    }

    /**
     * Add a team to that organization
     * @link http://developer.github.com/v3/orgs/teams/
     *
     * @param   string  $organization     the organization name
     * @param   string  $team             name of the new team
     * @param   string  $permission       its permission [PULL|PUSH|ADMIN]
     * @param   array   $repositories     (optional) its repositories names
     *
     * @return  array                     the teams
     *
     * @throws \InvalidArgumentException
     */
    public function addTeam($organization, $team, $permission = 'pull', array $repositories = array())
    {
        if (!in_array($permission, array(self::ADMIN, self::PUSH, self::PULL))) {
            throw new \InvalidArgumentException("Invalid value for the permission variable");
        }

        return $this->post('orgs/'.urlencode($organization).'/teams', array(
            'name' => $team,
            'permission' => $permission,
            'repo_names' => $repositories
        ));
    }

}
