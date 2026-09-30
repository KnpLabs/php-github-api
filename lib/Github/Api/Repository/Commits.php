<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;

/**
 * @link   https://docs.github.com/rest/commits/commits
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Commits extends AbstractApi
{
    /**
     * List commits.
     *
     * @link https://docs.github.com/rest/commits/commits#list-commits
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param array  $params     a list of extra parameters
     *
     * @return array
     */
    public function all($username, $repository, array $params)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/commits', $params);
    }

    /**
     * Compare two commits.
     *
     * @link https://docs.github.com/rest/commits/commits#compare-two-commits
     *
     * @param string      $username   the username
     * @param string      $repository the repository
     * @param string      $base       the base branch or commit SHA
     * @param string      $head       the head branch or commit SHA
     * @param string|null $mediaType  the Accept header media type to use
     * @param array       $params     a list of extra parameters
     *
     * @return array
     */
    public function compare($username, $repository, $base, $head, $mediaType = null, array $params = [])
    {
        $headers = [];
        if (null !== $mediaType) {
            $headers['Accept'] = $mediaType;
        }

        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/compare/'.rawurlencode($base).'...'.rawurlencode($head), $params, $headers);
    }

    /**
     * Get a commit.
     *
     * @link https://docs.github.com/rest/commits/commits#get-a-commit
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param string $sha        the SHA of the commit
     *
     * @return array
     */
    public function show($username, $repository, $sha)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/commits/'.rawurlencode($sha));
    }

    /**
     * List pull requests associated with a commit.
     *
     * @link https://docs.github.com/rest/commits/commits#list-pull-requests-associated-with-a-commit
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param string $sha        the SHA of the commit
     * @param array  $params     a list of extra parameters
     *
     * @return array
     */
    public function pulls($username, $repository, $sha, array $params = [])
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/commits/'.rawurlencode($sha).'/pulls', $params);
    }
}
