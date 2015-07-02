<?php

namespace Github\Api;

use Github\Api\CurrentUser\DeployKeys;
use Github\Api\CurrentUser\Emails;
use Github\Api\CurrentUser\Followers;
use Github\Api\CurrentUser\Memberships;
use Github\Api\CurrentUser\Notifications;
use Github\Api\CurrentUser\Watchers;
use Github\Api\CurrentUser\Starring;

/**
 * @link   http://developer.github.com/v3/users/
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @author Felipe Valtl de Mello <eu@felipe.im>
 */
class CurrentUser extends AbstractApi
{
    public function show()
    {
        return $this->get('user');
    }

    public function update(array $params)
    {
        return $this->patch('user', $params);
    }

    /**
     * @return Emails
     */
    public function emails()
    {
        return new Emails($this->client);
    }

    /**
     * @return Followers
     */
    public function follow()
    {
        return new Followers($this->client);
    }

    public function followers($page = 1)
    {
        return $this->get('user/followers', array(
            'page' => $page
        ));
    }

    /**
     * @link http://developer.github.com/v3/issues/#list-issues
     *
     * @param array $params
     * @param bool  $includeOrgIssues
     *
     * @return array
     */
    public function issues(array $params = array(), $includeOrgIssues = true)
    {
        return $this->get($includeOrgIssues ? 'issues' : 'user/issues', array_merge(array('page' => 1), $params));
    }

    /**
     * @return DeployKeys
     */
    public function keys()
    {
        return new DeployKeys($this->client);
    }

    /**
     * @return Notifications
     */
    public function notifications()
    {
        return new Notifications($this->client);
    }

    /**
     * @return Memberships
     */
    public function memberships()
    {
        return new Memberships($this->client);
    }

    /**
     * @link http://developer.github.com/v3/orgs/#list-user-organizations
     *
     * @return array
     */
    public function organizations()
    {
        return $this->get('user/orgs');
    }

    /**
     * @link https://developer.github.com/v3/orgs/teams/#list-user-teams
     *
     * @return array
     */
    public function teams()
    {
        return $this->get('user/teams');
    }

    /**
     * @link http://developer.github.com/v3/repos/#list-your-repositories
     *
     * @param string $type      role in the repository
     * @param string $sort      sort by
     * @param string $direction direction of sort, ask or desc
     *
     * @return array
     */
    public function repositories($type = 'owner', $sort = 'full_name', $direction = 'asc')
    {
        return $this->get('user/repos', array(
            'type' => $type,
            'sort' => $sort,
            'direction' => $direction
        ));
    }

    /**
     * @return Watchers
     */
    public function watchers()
    {
        return new Watchers($this->client);
    }

    /**
     * @deprecated Use watchers() instead
     */
    public function watched($page = 1)
    {
        return $this->get('user/watched', array(
            'page' => $page
        ));
    }

    /**
     * @return Starring
     */
    public function starring()
    {
        return new Starring($this->client);
    }

    /**
     * @deprecated Use starring() instead
     */
    public function starred($page = 1)
    {
        return $this->get('user/starred', array(
            'page' => $page
        ));
    }
    
    /**
     *  @link https://developer.github.com/v3/activity/watching/#list-repositories-being-watched
     */
    public function subscriptions()
    {
        return $this->get('user/subscriptions');
    }
}
