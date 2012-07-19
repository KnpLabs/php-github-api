<?php

namespace Github\Api;

use Github\Api\CurrentUser\DeployKeys;
use Github\Api\CurrentUser\Emails;
use Github\Api\CurrentUser\Followers;
use Github\Api\CurrentUser\Watchers;

/**
 * @link   http://developer.github.com/v3/users/
 * @author Joseph Bielawski <stloyd@gmail.com>
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
     * @return DeployKeys
     */
    public function keys()
    {
        return new DeployKeys($this->client);
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

    public function issues(array $params = array())
    {
        return $this->get('issues', array_merge(array('page' => 1), $params));
    }

    public function followers($page = 1)
    {
        return $this->get('user/followers', array(
            'page' => $page
        ));
    }

    /**
     * @return Watchers
     */
    public function watchers()
    {
        return new Watchers($this->client);
    }

    public function watched($page = 1)
    {
        return $this->get('user/watched', array(
            'page' => $page
        ));
    }
}
