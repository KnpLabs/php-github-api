<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/repos/keys/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class DeployKeys extends AbstractApi
{
    public function all($username, $repository)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/keys');
    }

    public function show($username, $repository, $id)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/keys/'.urlencode($id));
    }

    public function create($username, $repository, array $params)
    {
        if (!isset($params['title'], $params['key'])) {
            throw new MissingArgumentException(array('title', 'key'));
        }

        return $this->post('repos/'.urlencode($username).'/'.urlencode($repository).'/keys', $params);
    }

    public function update($username, $repository, $id, array $params)
    {
        if (!isset($params['title'], $params['key'])) {
            throw new MissingArgumentException(array('title', 'key'));
        }

        return $this->patch('repos/'.urlencode($username).'/'.urlencode($repository).'/keys/'.urlencode($id), $params);
    }

    public function remove($username, $repository, $id)
    {
        return $this->delete('repos/'.urlencode($username).'/'.urlencode($repository).'/keys/'.urlencode($id));
    }
}
