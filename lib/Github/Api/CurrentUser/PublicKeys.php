<?php

namespace Github\Api\CurrentUser;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   https://docs.github.com/rest/users/keys
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class PublicKeys extends AbstractApi
{
    /**
     * List deploy keys for the authenticated user.
     *
     * @link https://docs.github.com/rest/users/keys#list-public-ssh-keys-for-the-authenticated-user
     *
     * @return array
     */
    public function all()
    {
        return $this->get('/user/keys');
    }

    /**
     * Shows deploy key for the authenticated user.
     *
     * @link https://docs.github.com/rest/users/keys#get-a-public-ssh-key-for-the-authenticated-user
     *
     * @param int $id
     *
     * @return array
     */
    public function show($id)
    {
        return $this->get('/user/keys/'.$id);
    }

    /**
     * Adds deploy key for the authenticated user.
     *
     * @link https://docs.github.com/rest/users/keys#create-a-public-ssh-key-for-the-authenticated-user
     *
     * @param array $params
     *
     * @throws \Github\Exception\MissingArgumentException
     *
     * @return array
     */
    public function create(array $params)
    {
        if (!isset($params['title'], $params['key'])) {
            throw new MissingArgumentException(['title', 'key']);
        }

        return $this->post('/user/keys', $params);
    }

    /**
     * Removes deploy key for the authenticated user.
     *
     * @link https://docs.github.com/rest/users/keys#delete-a-public-ssh-key-for-the-authenticated-user
     *
     * @param int $id
     *
     * @return array
     */
    public function remove($id)
    {
        return $this->delete('/user/keys/'.$id);
    }
}
