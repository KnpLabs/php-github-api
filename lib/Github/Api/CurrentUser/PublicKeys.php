<?php declare(strict_types=1);

namespace Github\Api\CurrentUser;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/users/keys/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class PublicKeys extends AbstractApi
{
    /**
     * List deploy keys for the authenticated user.
     *
     * @link https://developer.github.com/v3/users/keys/
     */
    public function all(): array
    {
        return $this->get('/user/keys');
    }

    /**
     * Shows deploy key for the authenticated user.
     *
     * @link https://developer.github.com/v3/users/keys/
     */
    public function show(int $id): array
    {
        return $this->get('/user/keys/'.rawurlencode((string) $id));
    }

    /**
     * Adds deploy key for the authenticated user.
     *
     * @link https://developer.github.com/v3/users/keys/
     *
     * @throws \Github\Exception\MissingArgumentException
     */
    public function create(array $params): array
    {
        if (!isset($params['title'], $params['key'])) {
            throw new MissingArgumentException(['title', 'key']);
        }

        return $this->post('/user/keys', $params);
    }

    /**
     * Removes deploy key for the authenticated user.
     *
     * @link https://developer.github.com/v3/users/keys/
     */
    public function remove(int $id): array
    {
        return $this->delete('/user/keys/'.rawurlencode((string) $id));
    }
}
