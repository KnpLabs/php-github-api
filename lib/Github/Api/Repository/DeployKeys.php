<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   https://docs.github.com/rest/deploy-keys/deploy-keys
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class DeployKeys extends AbstractApi
{
    /**
     * List the deploy keys of a repository.
     *
     * @link https://docs.github.com/rest/deploy-keys/deploy-keys#list-deploy-keys
     *
     * @param string $username   the username
     * @param string $repository the repository
     *
     * @return array
     */
    public function all($username, $repository)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/keys');
    }

    /**
     * Get a single deploy key of a repository.
     *
     * @link https://docs.github.com/rest/deploy-keys/deploy-keys#get-a-deploy-key
     *
     * @param string     $username   the username
     * @param string     $repository the repository
     * @param int|string $id         the id of the deploy key
     *
     * @return array
     */
    public function show($username, $repository, $id)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/keys/'.rawurlencode($id));
    }

    /**
     * Create a deploy key for a repository.
     *
     * @link https://docs.github.com/rest/deploy-keys/deploy-keys#create-a-deploy-key
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param array  $params     the parameters (title, key, read_only)
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function create($username, $repository, array $params)
    {
        if (!isset($params['title'], $params['key'])) {
            throw new MissingArgumentException(['title', 'key']);
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/keys', $params);
    }

    /**
     * "Update" a deploy key of a repository.
     *
     * The GitHub Deploy Keys API has no update endpoint: this deletes the
     * existing key and recreates it with the given parameters.
     *
     * @link https://docs.github.com/rest/deploy-keys/deploy-keys
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param int    $id         the id of the deploy key to replace
     * @param array  $params     the parameters (title, key, read_only)
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function update($username, $repository, $id, array $params)
    {
        if (!isset($params['title'], $params['key'])) {
            throw new MissingArgumentException(['title', 'key']);
        }

        $this->remove($username, $repository, $id);

        return $this->create($username, $repository, $params);
    }

    /**
     * Delete a deploy key from a repository.
     *
     * @link https://docs.github.com/rest/deploy-keys/deploy-keys#delete-a-deploy-key
     *
     * @param string     $username   the username
     * @param string     $repository the repository
     * @param int|string $id         the id of the deploy key
     *
     * @return array
     */
    public function remove($username, $repository, $id)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/keys/'.rawurlencode($id));
    }
}
