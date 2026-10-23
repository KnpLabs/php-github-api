<?php

namespace Github\Api;

use Github\Api\Organization\Actions\Secrets;
use Github\Api\Organization\Actions\SelfHostedRunners;
use Github\Api\Organization\Actions\Variables;
use Github\Api\Organization\Hooks;
use Github\Api\Organization\Members;
use Github\Api\Organization\OrganizationRoles;
use Github\Api\Organization\OutsideCollaborators;
use Github\Api\Organization\SecretScanning;
use Github\Api\Organization\Teams;

/**
 * Getting organization information and managing authenticated organization account information.
 *
 * @link   https://docs.github.com/rest/orgs/orgs
 *
 * @author Antoine Berranger <antoine at ihqs dot net>
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Organization extends AbstractApi
{
    /**
     * List all organizations, in the order that they were created on GitHub.
     *
     * @link https://docs.github.com/rest/orgs/orgs#list-organizations
     *
     * @return array the organizations
     */
    public function all($since = '')
    {
        return $this->get('/organizations?since='.rawurlencode($since));
    }

    /**
     * Get extended information about an organization by its name.
     *
     * @link https://docs.github.com/rest/orgs/orgs#get-an-organization
     *
     * @param string $organization the organization to show
     *
     * @return array information about the organization
     */
    public function show($organization)
    {
        return $this->get('/orgs/'.rawurlencode($organization));
    }

    /**
     * Update the profile and default preferences of an organization.
     *
     * @link https://docs.github.com/rest/orgs/orgs#update-an-organization
     *
     * @param string $organization the organization to update
     * @param array  $params       the parameters to update (e.g. billing_email, company, name, description)
     *
     * @return array
     */
    public function update($organization, array $params)
    {
        return $this->patch('/orgs/'.rawurlencode($organization), $params);
    }

    /**
     * List all repositories across all the organizations that you can access.
     *
     * @link https://docs.github.com/rest/repos/repos#list-organization-repositories
     *
     * @param string $organization the user name
     * @param string $type         the type of repositories
     * @param int    $page         the page
     * @param string $sort         sort by
     * @param string $direction    direction of sort, asc or desc
     *
     * @return array the repositories
     */
    public function repositories($organization, $type = 'all', $page = 1, $sort = null, $direction = null)
    {
        $parameters = [
            'type' => $type,
            'page' => $page,
        ];

        if ($sort !== null) {
            $parameters['sort'] = $sort;
        }

        if ($direction !== null) {
            $parameters['direction'] = $direction;
        }

        return $this->get('/orgs/'.rawurlencode($organization).'/repos', $parameters);
    }

    /**
     * @return Members
     */
    public function members()
    {
        return new Members($this->getClient());
    }

    /**
     * @return Hooks
     */
    public function hooks()
    {
        return new Hooks($this->getClient());
    }

    /**
     * @return Teams
     */
    public function teams()
    {
        return new Teams($this->getClient());
    }

    /**
     * @return Secrets
     */
    public function secrets(): Secrets
    {
        return new Secrets($this->getClient());
    }

    /**
     * @return Variables
     */
    public function variables(): Variables
    {
        return new Variables($this->getClient());
    }

    /**
     * @return OutsideCollaborators
     */
    public function outsideCollaborators()
    {
        return new OutsideCollaborators($this->getClient());
    }

    /**
     * List issues in an organization assigned to the authenticated user.
     *
     * @link https://docs.github.com/rest/issues/issues#list-organization-issues-assigned-to-the-authenticated-user
     *
     * @param string $organization
     * @param array  $params
     * @param int    $page
     *
     * @return array
     */
    public function issues($organization, array $params = [], $page = 1)
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/issues', array_merge(['page' => $page], $params));
    }

    /**
     * @return SelfHostedRunners
     */
    public function runners(): SelfHostedRunners
    {
        return new SelfHostedRunners($this->getClient());
    }

    /**
     * @return SecretScanning
     */
    public function secretScanning(): SecretScanning
    {
        return new SecretScanning($this->getClient());
    }

    /**
     * @return OrganizationRoles
     */
    public function organizationRoles(): OrganizationRoles
    {
        return new OrganizationRoles($this->getClient());
    }
}
