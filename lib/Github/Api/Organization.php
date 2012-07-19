<?php

namespace Github\Api;

use Github\Api\Organization\Members;
use Github\Api\Organization\Teams;

/**
 * Getting organization information and managing authenticated organization account information.
 *
 * @link   http://developer.github.com/v3/orgs/
 * @author Antoine Berranger <antoine at ihqs dot net>
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Organization extends AbstractApi
{
    /**
     * Get extended information about an organization by its name
     * @link http://developer.github.com/v3/orgs/#get
     *
     * @param  string  $organization     the organization to show
     *
     * @return array                     informations about the organization
     */
    public function show($organization)
    {
        return $this->get('orgs/'.urlencode($organization));
    }

    public function update($organization, array $params)
    {
        return $this->patch('orgs/'.urlencode($organization), $params);
    }

    /**
     * List all repositories across all the organizations that you can access
     * @link http://developer.github.com/v3/repos/#list-organization-repositories
     *
     * @param  string  $organization     the user name
     * @param  string  $type             the type of repositories
     *
     * @return array                     the repositories
     */
    public function repositories($organization, $type = 'all')
    {
        return $this->get('orgs/'.urlencode($organization).'/repos', array(
            'type' => $type
        ));
    }

    /**
     * @return Members
     */
    public function members()
    {
        return new Members($this->client);
    }

    /**
     * @return Teams
     */
    public function teams()
    {
        return new Teams($this->client);
    }
}
