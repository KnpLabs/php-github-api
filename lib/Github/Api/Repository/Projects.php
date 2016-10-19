<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;
use Github\Exception\MissingArgumentException;

class Projects extends AbstractApi
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

    public function all($username, $repository, array $params = array())
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/projects', array_merge(array('page' => 1), $params));
    }

    public function show($username, $repository, $id, array $params = array())
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/projects/' . rawurlencode($id), array_merge(array('page' => 1), $params));
    }

    public function create($username, $repository, array $params)
    {
        if (!isset($params['name'])) {
            throw new MissingArgumentException(array('name'));
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/projects', $params);
    }

    public function update($username, $repository, $id, array $params)
    {
        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/projects/'.rawurlencode($id), $params);
    }

    public function deleteProject($username, $repository, $id)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/projects/'.rawurlencode($id));
    }

    public function columns()
    {
        return new Columns($this->client);
    }
}
