<?php declare(strict_types=1);

namespace Github\Api;

use Github\Api\Organization\Hooks;
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
     * @link https://developer.github.com/v3/orgs/#list-all-organizations
     *
     * @return array the organizations
     */
    public function all($since = ''): array
    {
        return $this->get('/organizations?since='.rawurlencode($since));
    }

    /**
     * Get extended information about an organization by its name.
     *
     * @link http://developer.github.com/v3/orgs/#get
     *
     * @param string $organization the organization to show
     *
     * @return array information about the organization
     */
    public function show(string $organization): array
    {
        return $this->get('/orgs/'.rawurlencode($organization));
    }

    public function update($organization, array $params)
    {
        return $this->patch('/orgs/'.rawurlencode($organization), $params);
    }

    /**
     * List all repositories across all the organizations that you can access.
     *
     * @link http://developer.github.com/v3/repos/#list-organization-repositories
     *
     * @param string $organization the user name
     * @param string $type         the type of repositories
     * @param int    $page         the page
     *
     * @return array the repositories
     */
    public function repositories(string $organization, string $type = 'all', int $page = 1): array
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/repos', [
            'type' => $type,
            'page' => $page,
        ]);
    }

    /**
     * @return Members
     */
    public function members(): Members
    {
        return new Members($this->client);
    }

    /**
     * @return Hooks
     */
    public function hooks(): Hooks
    {
        return new Hooks($this->client);
    }

    /**
     * @return Teams
     */
    public function teams(): Teams
    {
        return new Teams($this->client);
    }

    /**
     * @link http://developer.github.com/v3/issues/#list-issues
     *
     * @param $organization
     * @param array $params
     * @param int $page
     *
     * @return array
     */
    public function issues($organization, array $params = [], int $page = 1): array
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/issues', array_merge(['page' => $page], $params));
    }
}
