<?php

namespace Github\Api\CurrentUser;

use Github\Api\AbstractApi;

/**
 * @link   https://developer.github.com/v3/activity/watching/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Watchers extends AbstractApi
{
    /**
     * List repositories watched by the authenticated user
     * @link https://developer.github.com/v3/activity/watching/
     *
     * @param  integer $page
     * @return array
     */
    public function all($page = 1)
    {
        return $this->get('user/subscriptions', array(
            'page' => $page
        ));
    }

    /**
     * Check that the authenticated user watches a repository
     * @link https://developer.github.com/v3/activity/watching/
     *
     * @param  string $username   the user who owns the repo
     * @param  string $repository the name of the repo
     * @return array
     */
    public function check($username, $repository)
    {
        return $this->get('user/subscriptions/'.rawurlencode($username).'/'.rawurlencode($repository));
    }

    /**
     * Make the authenticated user watch a repository
     * @deprecated The new command is subscribe(), not watch()
     * @link https://developer.github.com/v3/activity/watching/
     *
     * @param  string $username   the user who owns the repo
     * @param  string $repository the name of the repo
     * @return array
     */
    public function watch($username, $repository)
    {
        return $this->put('user/subscriptions/'.rawurlencode($username).'/'.rawurlencode($repository));
    }

    /**
     * Make the authenticated user unwatch a repository
     * @deprecated The new command is unsubscribe(), not unwatch()
     * @link https://developer.github.com/v3/activity/watching/
     *
     * @param  string $username   the user who owns the repo
     * @param  string $repository the name of the repo
     * @return array
     */
    public function unwatch($username, $repository)
    {
        return $this->delete('user/subscriptions/'.rawurlencode($username).'/'.rawurlencode($repository));
    }

    /**
     * Make the authenticated user subscribe to a repository
     * @link https://developer.github.com/v3/activity/watching/
     *
     * @param  string $username   the user who owns the repo
     * @param  string $repository the name of the repo
     * @return array
     */
    public function subscribe($username, $repository)
    {
        return $this->put('user/subscriptions/'.rawurlencode($username).'/'.rawurlencode($repository));
    }

    /**
     * Make the authenticated user unsubscribe from a repository
     * @link https://developer.github.com/v3/activity/watching/
     *
     * @param  string $username   the user who owns the repo
     * @param  string $repository the name of the repo
     * @return array
     */
    public function unsubscribe($username, $repository)
    {
        return $this->delete('user/subscriptions/'.rawurlencode($username).'/'.rawurlencode($repository));
    }
}
