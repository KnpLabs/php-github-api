<?php

namespace Github\Api\Repository;

use Github\Api\Project\AbstractProjectApi;
use Github\Exception\MissingArgumentException;

class Projects extends AbstractProjectApi
{
    public function all($username, $repository, array $params = array())
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/projects', array_merge(array('page' => 1), $params));
    }

    public function create($username, $repository, array $params)
    {
        if (!isset($params['name'])) {
            throw new MissingArgumentException(array('name'));
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/projects', $params);
    }
}
