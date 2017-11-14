<?php declare(strict_types=1);

namespace Github\Api\Issue;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

class Assignees extends AbstractApi
{
    /**
     * List all the available assignees to which issues may be assigned.
     *
     * @param string $username
     * @param string $repository
     * @param array  $parameters
     *
     * @return array
     */
    public function listAvailable(string $username, string $repository, array $parameters = array()): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/assignees', $parameters);
    }

    /**
     * Check to see if a particular user is an assignee for a repository.
     *
     * @link https://developer.github.com/v3/issues/assignees/#check-assignee
     *
     * @param string $username
     * @param string $repository
     * @param string $assignee
     *
     * @return array
     */
    public function check(string $username, string $repository, string $assignee): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/assignees/' . rawurlencode($assignee));
    }

    /**
     * Add assignees to an Issue
     *
     * @link https://developer.github.com/v3/issues/assignees/#add-assignees-to-an-issue
     *
     * @param string $username
     * @param string $repository
     * @param string $issue
     * @param array  $parameters
     *
     * @return string
     * @throws MissingArgumentException
     */
    public function add(string $username, string $repository, string $issue, array $parameters): string
    {
        if (!isset($parameters['assignees'])) {
            throw new MissingArgumentException('assignees');
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode($issue).'/assignees', $parameters);
    }

    /**
     * Remove assignees from an Issue
     *
     * @link https://developer.github.com/v3/issues/assignees/#remove-assignees-from-an-issue
     *
     * @param string $username
     * @param string $repository
     * @param string $issue
     * @param array  $parameters
     *
     * @return string
     * @throws MissingArgumentException
     */
    public function remove(string $username, string $repository, string $issue, array $parameters): string
    {
        if (!isset($parameters['assignees'])) {
            throw new MissingArgumentException('assignees');
        }

        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode($issue).'/assignees', $parameters);
    }
}
