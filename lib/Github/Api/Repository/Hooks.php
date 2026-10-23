<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   https://docs.github.com/rest/repos/webhooks
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Hooks extends AbstractApi
{
    /**
     * List webhooks for a repository.
     *
     * @link https://docs.github.com/rest/repos/webhooks#list-repository-webhooks
     *
     * @param string $username   the username
     * @param string $repository the repository
     *
     * @return array
     */
    public function all($username, $repository)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/hooks');
    }

    /**
     * Get a single webhook for a repository.
     *
     * @link https://docs.github.com/rest/repos/webhooks#get-a-repository-webhook
     *
     * @param string     $username   the username
     * @param string     $repository the repository
     * @param int|string $id         the id of the webhook
     *
     * @return array
     */
    public function show($username, $repository, $id)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/hooks/'.rawurlencode($id));
    }

    /**
     * Create a webhook for a repository.
     *
     * @link https://docs.github.com/rest/repos/webhooks#create-a-repository-webhook
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param array  $params     the parameters (name, config, events, active)
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function create($username, $repository, array $params)
    {
        if (!isset($params['name'], $params['config'])) {
            throw new MissingArgumentException(['name', 'config']);
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/hooks', $params);
    }

    /**
     * Update a webhook for a repository.
     *
     * @link https://docs.github.com/rest/repos/webhooks#update-a-repository-webhook
     *
     * @param string     $username   the username
     * @param string     $repository the repository
     * @param int|string $id         the id of the webhook
     * @param array      $params     the parameters to update (config, events, add_events, remove_events, active)
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function update($username, $repository, $id, array $params)
    {
        if (!isset($params['config'])) {
            throw new MissingArgumentException(['config']);
        }

        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/hooks/'.rawurlencode($id), $params);
    }

    /**
     * Ping a webhook for a repository.
     *
     * @link https://docs.github.com/rest/repos/webhooks#ping-a-repository-webhook
     *
     * @param string     $username   the username
     * @param string     $repository the repository
     * @param int|string $id         the id of the webhook
     *
     * @return array
     */
    public function ping($username, $repository, $id)
    {
        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/hooks/'.rawurlencode($id).'/pings');
    }

    /**
     * Trigger a test push event for a webhook for a repository.
     *
     * @link https://docs.github.com/rest/repos/webhooks#test-the-push-repository-webhook
     *
     * @param string     $username   the username
     * @param string     $repository the repository
     * @param int|string $id         the id of the webhook
     *
     * @return array
     */
    public function test($username, $repository, $id)
    {
        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/hooks/'.rawurlencode($id).'/tests');
    }

    /**
     * Delete a webhook for a repository.
     *
     * @link https://docs.github.com/rest/repos/webhooks#delete-a-repository-webhook
     *
     * @param string     $username   the username
     * @param string     $repository the repository
     * @param int|string $id         the id of the webhook
     *
     * @return array
     */
    public function remove($username, $repository, $id)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/hooks/'.rawurlencode($id));
    }
}
