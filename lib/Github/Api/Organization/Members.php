<?php

namespace Github\Api\Organization;

use Github\Api\AbstractApi;

/**
 * @link   https://docs.github.com/rest/orgs/members
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Members extends AbstractApi
{
    /**
     * List members of an organization, or its public members.
     *
     * @link https://docs.github.com/rest/orgs/members#list-organization-members
     * @link https://docs.github.com/rest/orgs/members#list-public-organization-members
     *
     * @param string      $organization the organization
     * @param string|null $type         if not null, list the public members instead
     * @param string      $filter       filter members returned (2fa_disabled or all)
     * @param string|null $role         filter members returned by their role (all, admin or member)
     *
     * @return array list of members
     */
    public function all($organization, $type = null, $filter = 'all', $role = null)
    {
        $parameters = [];
        $path = '/orgs/'.rawurlencode($organization).'/';
        if (null === $type) {
            $path .= 'members';
            if (null !== $filter) {
                $parameters['filter'] = $filter;
            }
            if (null !== $role) {
                $parameters['role'] = $role;
            }
        } else {
            $path .= 'public_members';
        }

        return $this->get($path, $parameters);
    }

    /**
     * Check if a user is, publicly or privately, a member of the organization.
     *
     * @link https://docs.github.com/rest/orgs/members#check-organization-membership-for-a-user
     *
     * @param string $organization the organization
     * @param string $username     the user to check
     *
     * @return array|string
     */
    public function show($organization, $username)
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/members/'.rawurlencode($username));
    }

    /**
     * Get the organization membership (role and state) of a user.
     *
     * @link https://docs.github.com/rest/orgs/members#get-organization-membership-for-a-user
     *
     * @param string $organization the organization
     * @param string $username     the user to check
     *
     * @return array
     */
    public function member($organization, $username)
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/memberships/'.rawurlencode($username));
    }

    /**
     * Check if a user is a public member of the organization.
     *
     * @link https://docs.github.com/rest/orgs/members#check-public-organization-membership-for-a-user
     *
     * @param string $organization the organization
     * @param string $username     the user to check
     *
     * @return array|string
     */
    public function check($organization, $username)
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/public_members/'.rawurlencode($username));
    }

    /**
     * Publicize a user's membership of the organization.
     *
     * @link https://docs.github.com/rest/orgs/members#set-public-organization-membership-for-the-authenticated-user
     *
     * @param string $organization the organization
     * @param string $username     the user to publicize
     *
     * @return array|string
     */
    public function publicize($organization, $username)
    {
        return $this->put('/orgs/'.rawurlencode($organization).'/public_members/'.rawurlencode($username));
    }

    /**
     * Conceal a user's membership of the organization.
     *
     * @link https://docs.github.com/rest/orgs/members#remove-public-organization-membership-for-the-authenticated-user
     *
     * @param string $organization the organization
     * @param string $username     the user to conceal
     *
     * @return array|string
     */
    public function conceal($organization, $username)
    {
        return $this->delete('/orgs/'.rawurlencode($organization).'/public_members/'.rawurlencode($username));
    }

    /**
     * Add a user to the organization, or update their existing membership.
     *
     * @link https://docs.github.com/rest/orgs/members#set-organization-membership-for-a-user
     *
     * @param string $organization the organization
     * @param string $username     the user to add
     * @param array  $params       the parameters (e.g. role)
     *
     * @return array
     */
    public function add($organization, $username, array $params = [])
    {
        return $this->put('/orgs/'.rawurlencode($organization).'/memberships/'.rawurlencode($username), $params);
    }

    /**
     * Add a user to the organization.
     *
     * @link https://docs.github.com/rest/orgs/members#set-organization-membership-for-a-user
     *
     * @param string $organization the organization
     * @param string $username     the user to add
     *
     * @return array
     */
    public function addMember($organization, $username)
    {
        return $this->add($organization, $username);
    }

    /**
     * Remove a member from the organization (also removes them from all teams).
     *
     * @link https://docs.github.com/rest/orgs/members#remove-an-organization-member
     *
     * @param string $organization the organization
     * @param string $username     the user to remove
     *
     * @return array|string
     */
    public function remove($organization, $username)
    {
        return $this->delete('/orgs/'.rawurlencode($organization).'/members/'.rawurlencode($username));
    }
}
