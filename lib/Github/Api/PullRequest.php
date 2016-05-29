<?php

namespace Github\Api;

use Github\Api\PullRequest\Comments;
use Github\Exception\MissingArgumentException;

/**
 * API for accessing Pull Requests from your Git/Github repositories.
 *
 * @link   http://developer.github.com/v3/pulls/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class PullRequest extends AbstractApi
{
    /**
     * Get a listing of a project's pull requests by the username, repository and (optionally) state.
     *
     * @link http://developer.github.com/v3/pulls/
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param array  $params     a list of extra parameters.
     *
     * @return array array of pull requests for the project
     */
    public function all($username, $repository, array $params = array())
    {
        $parameters = array_merge(array(
            'page' => 1,
            'per_page' => 30
        ), $params);

        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls', $parameters);
    }

    /**
     * Show all details of a pull request, including the discussions.
     *
     * @link http://developer.github.com/v3/pulls/
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param string $id         the ID of the pull request for which details are retrieved
     *
     * @return array array of pull requests for the project
     */
    public function show($username, $repository, $id)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/'.rawurlencode($id));
    }

    public function commits($username, $repository, $id)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/'.rawurlencode($id).'/commits');
    }

    public function files($username, $repository, $id)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/'.rawurlencode($id).'/files');
    }

    public function comments()
    {
        return new Comments($this->client);
    }

    /**
     * Create a pull request.
     *
     * @link   http://developer.github.com/v3/pulls/
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param array  $params     A String of the branch or commit SHA that you want your changes to be pulled to.
     *                           A String of the branch or commit SHA of your changes. Typically this will be a branch.
     *                           If the branch is in a fork of the original repository, specify the username first:
     *                           "my-user:some-branch". The String title of the Pull Request. The String body of
     *                           the Pull Request. The issue number. Used when title and body is not set.
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function create($username, $repository, array $params)
    {
        // Two ways to create PR, using issue or title
        if (!isset($params['issue']) && !isset($params['title'])) {
            throw new MissingArgumentException(array('issue', 'title'));
        }

        if (!isset($params['base'], $params['head'])) {
            throw new MissingArgumentException(array('base', 'head'));
        }

        // If `issue` is not sent, then `body` must be sent
        if (!isset($params['issue']) && !isset($params['body'])) {
            throw new MissingArgumentException(array('issue', 'body'));
        }

        return $this->post('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls', $params);
    }

    public function update($username, $repository, $id, array $params)
    {
        if (isset($params['state']) && !in_array($params['state'], array('open', 'closed'))) {
            $params['state'] = 'open';
        }

        return $this->patch('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/'.rawurlencode($id), $params);
    }

    public function merged($username, $repository, $id)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/'.rawurlencode($id).'/merge');
    }

    public function merge($username, $repository, $id, $message, $sha, $squash = false, $title = null)
    {
        $params = array(
            'commit_message' => $message,
            'sha' => $sha,
            'squash' => $squash,
        );

        if (is_string($title)) {
            $params['commit_title'] = $title;
        }

        return $this->put('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/'.rawurlencode($id).'/merge', $params);
    }
}
