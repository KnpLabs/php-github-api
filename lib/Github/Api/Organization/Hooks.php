<?php declare(strict_types=1);

namespace Github\Api\Organization;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

class Hooks extends AbstractApi
{
    /**
     * List hooks.
     *
     * @link https://developer.github.com/v3/orgs/hooks/#list-hooks
     * @param string $organization
     * @return array
     */
    public function all(string $organization): array
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/hooks');
    }

    /**
     * Get a single hook.
     * @link https://developer.github.com/v3/orgs/hooks/#get-single-hook
     *
     * @param string $organization
     * @param int    $id
     * @return array
     */
    public function show(string $organization, int $id): array
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/hooks/'.rawurlencode((string) $id));
    }

    /**
     * Create a hook.
     *
     * @link https://developer.github.com/v3/orgs/hooks/#create-a-hook
     * @param string $organization
     * @param array  $params
     * @return array
     * @throws \Github\Exception\MissingArgumentException
     */
    public function create(string $organization, array $params): array
    {
        if (!isset($params['name'], $params['config'])) {
            throw new MissingArgumentException(['name', 'config']);
        }

        return $this->post('/orgs/'.rawurlencode($organization).'/hooks', $params);
    }

    /**
     * Edit a hook.
     *
     * @link https://developer.github.com/v3/orgs/hooks/#edit-a-hook
     * @param string $organization
     * @param int    $id
     * @param array  $params
     * @return array
     * @throws \Github\Exception\MissingArgumentException
     */
    public function update(string $organization, int $id, array $params): array
    {
        if (!isset($params['config'])) {
            throw new MissingArgumentException(['config']);
        }

        return $this->patch('/orgs/'.rawurlencode($organization).'/hooks/'.rawurlencode((string) $id), $params);
    }

    /**
     * Ping a hook.
     *
     * @link https://developer.github.com/v3/orgs/hooks/#ping-a-hook
     * @param string $organization
     * @param int    $id
     * @return null
     */
    public function ping(string $organization, int $id)
    {
        return $this->post('/orgs/'.rawurlencode($organization).'/hooks/'.rawurlencode((string) $id).'/pings');
    }

    /**
     * Delete a hook.
     *
     * @link https://developer.github.com/v3/orgs/hooks/#delete-a-hook
     * @param string $organization
     * @param int    $id
     * @return null
     */
    public function remove(string $organization, int $id)
    {
        return $this->delete('/orgs/'.rawurlencode($organization).'/hooks/'.rawurlencode((string) $id));
    }
}
