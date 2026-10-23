<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   https://docs.github.com/rest/issues/labels
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Labels extends AbstractApi
{
    /**
     * List labels for a repository.
     *
     * @link https://docs.github.com/rest/issues/labels#list-labels-for-a-repository
     *
     * @param string $username   the username
     * @param string $repository the repository
     *
     * @return array
     */
    public function all($username, $repository)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/labels');
    }

    /**
     * Get a single label of a repository.
     *
     * @link https://docs.github.com/rest/issues/labels#get-a-label
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param string $label      the name of the label
     *
     * @return array
     */
    public function show($username, $repository, $label)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/labels/'.rawurlencode($label));
    }

    /**
     * Create a label for a repository.
     *
     * @link https://docs.github.com/rest/issues/labels#create-a-label
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param array  $params     the parameters (name, color, description)
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function create($username, $repository, array $params)
    {
        if (!isset($params['name'], $params['color'])) {
            throw new MissingArgumentException(['name', 'color']);
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/labels', $params);
    }

    /**
     * Update a label of a repository.
     *
     * @link https://docs.github.com/rest/issues/labels#update-a-label
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param string $label      the name of the label to update
     * @param array  $params     the parameters to update (new_name, color, description)
     *
     * @return array
     */
    public function update($username, $repository, $label, array $params)
    {
        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/labels/'.rawurlencode($label), $params);
    }

    /**
     * Delete a label from a repository.
     *
     * @link https://docs.github.com/rest/issues/labels#delete-a-label
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param string $label      the name of the label
     *
     * @return array
     */
    public function remove($username, $repository, $label)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/labels/'.rawurlencode($label));
    }
}
