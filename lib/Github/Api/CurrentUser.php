<?php declare(strict_types=1);

namespace Github\Api;

use Github\Api\CurrentUser\Emails;
use Github\Api\CurrentUser\Followers;
use Github\Api\CurrentUser\Memberships;
use Github\Api\CurrentUser\Notifications;
use Github\Api\CurrentUser\PublicKeys;
use Github\Api\CurrentUser\Starring;
use Github\Api\CurrentUser\Watchers;

/**
 * @link   http://developer.github.com/v3/users/
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @author Felipe Valtl de Mello <eu@felipe.im>
 */
class CurrentUser extends AbstractApi
{
    public function show()
    {
        return $this->get('/user');
    }

    public function update(array $params)
    {
        return $this->patch('/user', $params);
    }

    public function emails(): Emails
    {
        return new Emails($this->client);
    }

    public function follow(): Followers
    {
        return new Followers($this->client);
    }

    public function followers($page = 1)
    {
        return $this->get('/user/followers', [
            'page' => $page
        ]);
    }

    /**
     * @link http://developer.github.com/v3/issues/#list-issues
     */
    public function issues(array $params = [], bool $includeOrgIssues = true): array
    {
        return $this->get($includeOrgIssues ? '/issues' : '/user/issues', array_merge(['page' => 1], $params));
    }

    public function keys(): PublicKeys
    {
        return new PublicKeys($this->client);
    }

    public function notifications(): Notifications
    {
        return new Notifications($this->client);
    }

    public function memberships(): Memberships
    {
        return new Memberships($this->client);
    }

    /**
     * @link http://developer.github.com/v3/orgs/#list-user-organizations
     */
    public function organizations(): array
    {
        return $this->get('/user/orgs');
    }

    /**
     * @link https://developer.github.com/v3/orgs/teams/#list-user-teams
     */
    public function teams(): array
    {
        return $this->get('/user/teams');
    }

    /**
     * @link http://developer.github.com/v3/repos/#list-your-repositories
     *
     * @param string $type      role in the repository
     * @param string $sort      sort by
     * @param string $direction direction of sort, asc or desc
     */
    public function repositories(string $type = 'owner', string $sort = 'full_name', string $direction = 'asc'): array
    {
        return $this->get('/user/repos', [
            'type' => $type,
            'sort' => $sort,
            'direction' => $direction
        ]);
    }

    public function watchers(): Watchers
    {
        return new Watchers($this->client);
    }

    public function watched($page = 1)
    {
        return $this->get('/user/watched', [
            'page' => $page
        ]);
    }

    public function starring(): Starring
    {
        return new Starring($this->client);
    }

    public function starred($page = 1)
    {
        return $this->get('/user/starred', [
            'page' => $page
        ]);
    }

    public function subscriptions()
    {
        return $this->get('/user/subscriptions');
    }

    /**
     * @link https://developer.github.com/v3/integrations/#list-installations-for-user
     */
    public function installations(array $params = [])
    {
        return $this->get('/user/installations', array_merge(['page' => 1], $params));
    }

    /**
     * @link https://developer.github.com/v3/integrations/installations/#list-repositories-accessible-to-the-user-for-an-installation
     *
     * @param string $installationId  the ID of the Installation
     */
    public function repositoriesByInstallation(string $installationId, array $params = [])
    {
        return $this->get(sprintf('/user/installations/%s/repositories', $installationId), array_merge(['page' => 1], $params));
    }
}
