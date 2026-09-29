<?php

namespace Github\Api\Issue;

use Github\Api\AbstractApi;

/**
 * @link   https://docs.github.com/rest/issues/events
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Events extends AbstractApi
{
    /**
     * Get all events for an issue.
     *
     * @link https://docs.github.com/rest/issues/events#list-issue-events
     *
     * @param string   $username
     * @param string   $repository
     * @param int|null $issue
     * @param int      $page
     *
     * @return array
     */
    public function all($username, $repository, $issue = null, $page = 1)
    {
        if (null !== $issue) {
            $path = '/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.$issue.'/events';
        } else {
            $path = '/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/events';
        }

        return $this->get($path, [
            'page' => $page,
        ]);
    }

    /**
     * Display an event for an issue.
     *
     * @link https://docs.github.com/rest/issues/events#get-an-issue-event
     *
     * @param string $username
     * @param string $repository
     * @param string $event
     *
     * @return array
     */
    public function show($username, $repository, $event)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/events/'.rawurlencode($event));
    }
}
