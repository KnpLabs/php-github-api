<?php

namespace Github\Api;

use Github\Api\Issue\Comments;
use Github\Api\Issue\Events;
use Github\Api\Issue\Labels;
use Github\Api\Issue\Milestones;
use Github\Exception\MissingArgumentException;

/**
 * Listing issues, searching, editing and closing your projects issues.
 *
 * @link   http://develop.github.com/p/issues.html
 *
 * @author Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Issue extends AbstractApi
{
    /**
     * List issues by username, repo and state.
     *
     * @link http://developer.github.com/v3/issues/
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param array  $params     the additional parameters like milestone, assignees, labels, sort, direction
     *
     * @return array list of issues found
     */
    public function all($username, $repository, array $params = array())
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues', array_merge(array('page' => 1), $params));
    }

    /**
     * Search issues by username, repo, state and keyword.
     *
     * @link http://developer.github.com/v3/search/#search-issues
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param string $state      the issue state, can be open or closed
     * @param string $keyword    the keyword to filter issues by
     *
     * @return array list of issues found
     */
    public function find($username, $repository, $state, $keyword)
    {
        if (!in_array($state, array('open', 'closed'))) {
            $state = 'open';
        }

        return $this->get('legacy/issues/search/'.rawurlencode($username).'/'.rawurlencode($repository).'/'.rawurlencode($state).'/'.rawurlencode($keyword));
    }

    /**
     * List issues by organization.
     *
     * @link http://developer.github.com/v3/issues/
     *
     * @param string $organization the organization
     * @param string $state        the issue state, can be open or closed
     * @param array  $params       the additional parameters like milestone, assignees, labels, sort, direction
     *
     * @return array list of issues found
     */
    public function org($organization, $state, array $params = array())
    {
        if (!in_array($state, array('open', 'closed'))) {
            $state = 'open';
        }

        return $this->get('orgs/'.rawurlencode($organization).'/issues', array_merge(array('page' => 1, 'state' => $state), $params));
    }

    /**
     * Get extended information about an issue by its username, repo and number.
     *
     * @link http://developer.github.com/v3/issues/
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param string $id         the issue number
     *
     * @return array information about the issue
     */
    public function show($username, $repository, $id)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode($id));
    }

    /**
     * Create a new issue for the given username and repo.
     * The issue is assigned to the authenticated user. Requires authentication.
     *
     * @link http://developer.github.com/v3/issues/
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param array  $params     the new issue data
     *
     * @throws MissingArgumentException
     *
     * @return array information about the issue
     */
    public function create($username, $repository, array $params)
    {
        if (!isset($params['title'], $params['body'])) {
            throw new MissingArgumentException(array('title', 'body'));
        }

        return $this->post('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues', $params);
    }

    /**
     * Update issue information's by username, repo and issue number. Requires authentication.
     *
     * @link http://developer.github.com/v3/issues/
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param string $id         the issue number
     * @param array  $params     key=>value user attributes to update.
     *                           key can be title or body
     *
     * @return array information about the issue
     */
    public function update($username, $repository, $id, array $params)
    {
        return $this->patch('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode($id), $params);
    }

    /**
     * List an issue comments.
     *
     * @link http://developer.github.com/v3/issues/comments/
     *
     * @return Comments
     */
    public function comments()
    {
        return new Comments($this->client);
    }

    /**
     * List all project events.
     *
     * @link http://developer.github.com/v3/issues/events/
     *
     * @return Events
     */
    public function events()
    {
        return new Events($this->client);
    }

    /**
     * List all project labels.
     *
     * @link http://developer.github.com/v3/issues/labels/
     *
     * @return Labels
     */
    public function labels()
    {
        return new Labels($this->client);
    }

    /**
     * List all project milestones.
     *
     * @link http://developer.github.com/v3/issues/milestones/
     *
     * @return Milestones
     */
    public function milestones()
    {
        return new Milestones($this->client);
    }
}
