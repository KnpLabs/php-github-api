<?php

namespace Github\Api;

/**
 * API for accessing Pull Requests from your Git/Github repositories.
 *
 * @link      http://develop.github.com/p/pulls.html
 * @author    Nicolas Pastorino <nicolas.pastorino at gmail dot com>
 * @license   MIT License
 */
class PullRequest extends Api
{
    /**
     * Get a listing of a project's pull requests by the username, repo, and optionally state.
     * @link    http://developer.github.com/v3/pulls/
     *
     * @param   string $username          the username
     * @param   string $repo              the repo
     * @param   string $state             the state of the fetched pull requests.
     *                                    The API seems to automatically default to 'open'
     * @return  array                     array of pull requests for the project
     */
    public function listPullRequests($username, $repo, $state = 'open')
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/pulls?state='.urlencode($state));
    }

    /**
     * Show all details of a pull request, including the discussions.
     * @link    http://developer.github.com/v3/pulls/
     *
     * @param   string $username          the username
     * @param   string $repo              the repo
     * @param   string $id                the ID of the pull request for which details are retrieved
     * @return  array                     array of pull requests for the project
     */
    public function show($username, $repo, $id)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/pulls/'.urlencode($id));
    }

    /**
     * Create a pull request
     *
     * @link      http://develop.github.com/p/pulls.html
     * @param   string $username          the username
     * @param   string $repo              the repo
     * @param   string $base              A String of the branch or commit SHA that you want your changes to be pulled to.
     * @param   string $head              A String of the branch or commit SHA of your changes.
     *                                    Typically this will be a branch. If the branch is in a fork of the original repository,
     *                                    specify the username first: "my-user:some-branch".
     * @param   string $title             The String title of the Pull Request. Used in pair with $body.
     * @param   string $body              The String body of the Pull Request. Used in pair with $title.
     * @return  array                     array of pull requests for the project
     */
    public function create($username, $repo, $base, $head, $title, $body = null)
    {
        return $this->post('repos/'.urlencode($username).'/'.urlencode($repo).'/pulls', array(
            'head' => $head,
            'base' => $base,
            'title' => $title,
            'body' => $body,
        ));
    }
}
