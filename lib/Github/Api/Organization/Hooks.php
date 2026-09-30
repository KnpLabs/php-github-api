<?php

namespace Github\Api\Organization;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

class Hooks extends AbstractApi
{
    /**
     * List hooks.
     *
     * @link https://docs.github.com/rest/orgs/webhooks#list-organization-webhooks
     *
     * @param string $organization
     *
     * @return array
     */
    public function all($organization)
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/hooks');
    }

    /**
     * Get a single hook.
     *
     * @link https://docs.github.com/rest/orgs/webhooks#get-an-organization-webhook
     *
     * @param string $organization
     * @param int    $id
     *
     * @return array
     */
    public function show($organization, $id)
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/hooks/'.$id);
    }

    /**
     * Create a hook.
     *
     * @link https://docs.github.com/rest/orgs/webhooks#create-an-organization-webhook
     *
     * @param string $organization
     * @param array  $params
     *
     * @throws \Github\Exception\MissingArgumentException
     *
     * @return array
     */
    public function create($organization, array $params)
    {
        if (!isset($params['name'], $params['config'])) {
            throw new MissingArgumentException(['name', 'config']);
        }

        return $this->post('/orgs/'.rawurlencode($organization).'/hooks', $params);
    }

    /**
     * Edit a hook.
     *
     * @link https://docs.github.com/rest/orgs/webhooks#update-an-organization-webhook
     *
     * @param string $organization
     * @param int    $id
     * @param array  $params
     *
     * @throws \Github\Exception\MissingArgumentException
     *
     * @return array
     */
    public function update($organization, $id, array $params)
    {
        if (!isset($params['config'])) {
            throw new MissingArgumentException(['config']);
        }

        return $this->patch('/orgs/'.rawurlencode($organization).'/hooks/'.$id, $params);
    }

    /**
     * Ping a hook.
     *
     * @link https://docs.github.com/rest/orgs/webhooks#ping-an-organization-webhook
     *
     * @param string $organization
     * @param int    $id
     *
     * @return array|string
     */
    public function ping($organization, $id)
    {
        return $this->post('/orgs/'.rawurlencode($organization).'/hooks/'.$id.'/pings');
    }

    /**
     * Delete a hook.
     *
     * @link https://docs.github.com/rest/orgs/webhooks#delete-an-organization-webhook
     *
     * @param string $organization
     * @param int    $id
     *
     * @return array|string
     */
    public function remove($organization, $id)
    {
        return $this->delete('/orgs/'.rawurlencode($organization).'/hooks/'.$id);
    }
}
