<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/issues/labels/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Labels extends AbstractApi
{
    public function all($username, $repository)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/labels');
    }

    public function show($username, $repository, $label)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/labels/'.urlencode($label));
    }

    public function create($username, $repository, array $params)
    {
        if (!isset($params['name'], $params['color'])) {
            throw new MissingArgumentException(array('name', 'color'));
        }

        return $this->post('repos/'.urlencode($username).'/'.urlencode($repository).'/labels', $params);
    }

    public function update($username, $repository, $label, array $params)
    {
        if (!isset($params['name'], $params['color'])) {
            throw new MissingArgumentException(array('name', 'color'));
        }

        return $this->patch('repos/'.urlencode($username).'/'.urlencode($repository).'/labels/'.urlencode($label), $params);
    }

    public function remove($username, $repository, $label)
    {
        return $this->delete('repos/'.urlencode($username).'/'.urlencode($repository).'/labels/'.urlencode($label));
    }
}
