<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   https://docs.github.com/rest/commits/statuses
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Statuses extends AbstractApi
{
    /**
     * @link https://docs.github.com/rest/commits/statuses#list-commit-statuses-for-a-reference
     *
     * @param string $username
     * @param string $repository
     * @param string $sha
     *
     * @return array
     */
    public function show($username, $repository, $sha)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/commits/'.rawurlencode($sha).'/statuses');
    }

    /**
     * @link https://docs.github.com/rest/commits/statuses#get-the-combined-status-for-a-specific-reference
     *
     * @param string $username
     * @param string $repository
     * @param string $sha
     *
     * @return array
     */
    public function combined($username, $repository, $sha)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/commits/'.rawurlencode($sha).'/status');
    }

    /**
     * @link https://docs.github.com/rest/commits/statuses#create-a-commit-status
     *
     * @param string $username
     * @param string $repository
     * @param string $sha
     * @param array  $params
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function create($username, $repository, $sha, array $params = [])
    {
        if (!isset($params['state'])) {
            throw new MissingArgumentException('state');
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/statuses/'.rawurlencode($sha), $params);
    }
}
