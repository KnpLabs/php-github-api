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
    /**
     * Get all deploy keys for a repository
     * @link https://developer.github.com/v3/repos/keys/#list
     *
     * @param  string $username   the username
     * @param  string $repository the repository
     * @param  int    $page       the page
     * @param  int    $perPage    the number of results by page
     *
     * @return array list of deploy keys collaborators for the repository
     */
    public function all($username, $repository, $page = 1, $perPage = 30)
    {
        $parameters = array(
            'page' => $page,
            'per_page' => $perPage
        );

        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/keys', $parameters);
    }

    public function show($username, $repository, $id)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/keys/'.rawurlencode($id));
    }

    public function create($username, $repository, array $params)
    {
        if (!isset($params['title'], $params['key'])) {
            throw new MissingArgumentException(array('title', 'key'));
        }

        return $this->post('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/keys', $params);
    }

    public function update($username, $repository, $id, array $params)
    {
        if (!isset($params['title'], $params['key'])) {
            throw new MissingArgumentException(array('title', 'key'));
        }

        return $this->patch('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/keys/'.rawurlencode($id), $params);
    }

    public function remove($username, $repository, $id)
    {
        return $this->delete('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/keys/'.rawurlencode($id));
    }
}
