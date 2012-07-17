<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/issues/hooks/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Hooks extends AbstractApi
{
    public function all($username, $repository)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/hooks');
    }

    public function show($username, $repository, $id)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/hooks/'.urlencode($id));
    }

    public function create($username, $repository, array $params)
    {
        if (!isset($params['name'], $params['config'])) {
            throw new MissingArgumentException(array('name', 'config'));
        }

        return $this->post('repos/'.urlencode($username).'/'.urlencode($repository).'/hooks', $params);
    }

    public function update($username, $repository, $id, array $params)
    {
        if (!isset($params['name'], $params['config'])) {
            throw new MissingArgumentException(array('name', 'config'));
        }

        return $this->patch('repos/'.urlencode($username).'/'.urlencode($repository).'/hooks/'.urlencode($id), $params);
    }

    public function test($username, $repository, $id)
    {
        return $this->post('repos/'.urlencode($username).'/'.urlencode($repository).'/hooks/'.urlencode($id).'/test');
    }

    public function remove($username, $repository, $id)
    {
        return $this->delete('repos/'.urlencode($username).'/'.urlencode($repository).'/hooks/'.urlencode($id));
    }
}
