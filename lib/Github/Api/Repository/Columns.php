<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;
use Github\Exception\MissingArgumentException;

class Columns extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Configure the accept header for Early Access to the projects api
     *
     * @see https://developer.github.com/v3/repos/projects/#projects
     */
    public function configure()
    {
        $this->acceptHeaderValue = 'application/vnd.github.inertia-preview+json';
    }

    public function all($username, $repository, $projectId, array $params = array())
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/projects/' . rawurlencode($projectId) . '/columns', array_merge(array('page' => 1), $params));
    }

    public function show($username, $repository, $id)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/projects/columns/'.rawurlencode($id));
    }

    public function create($username, $repository, $projectId, array $params)
    {
        if (!isset($params['name'])) {
            throw new MissingArgumentException(array('name'));
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/projects/' . rawurlencode($projectId) . '/columns', $params);
    }

    public function update($username, $repository, $id, array $params)
    {
        if (!isset($params['name'])) {
            throw new MissingArgumentException(array('name'));
        }

        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/projects/columns/' . rawurlencode($id), $params);
    }

    public function deleteColumn($username, $repository, $id)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/projects/columns/'.rawurlencode($id));
    }

    public function move($username, $repository, $id, array $params)
    {
        if (!isset($params['position'])) {
            throw new MissingArgumentException(array('position'));
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/projects/columns/' . rawurlencode($id) . '/moves', $params);
    }

    public function cards()
    {
        return new Cards($this->client);
    }
}
