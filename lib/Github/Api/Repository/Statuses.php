<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/repos/statuses/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Statuses extends AbstractApi
{
    /**
     * @link http://developer.github.com/v3/repos/statuses/#list-statuses-for-a-specific-sha
     *
     * @param string $username
     * @param string $repository
     * @param string $sha
     *
     * @return array
     */
    public function show($username, $repository, $sha)
    {
        return $this->get('/repos/'.urlencode($username).'/'.urlencode($repository).'/statuses/'.urlencode($sha));
    }

    /**
     * @link http://developer.github.com/v3/repos/statuses/#create-a-status
     *
     * @param string $username
     * @param string $repository
     * @param string $sha
     * @param array $params
     *
     * @return array
     *
     * @throws MissingArgumentException
     */
    public function create($username, $repository, $sha, array $params = array())
    {
        if (!isset($params['state'])) {
            throw new MissingArgumentException('state');
        }

        return $this->post('repos/'.urlencode($username).'/'.urlencode($repository).'/statuses/'.urlencode($sha), $params);
    }
}
