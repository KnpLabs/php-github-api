<?php

namespace Github\Api\CurrentUser;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/users/keys/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class DeployKeys extends AbstractApi
{
    /**
     * List deploy keys for the authenticated user.
     *
     * @link http://developer.github.com/v3/repos/keys/
     *
     * @return array
     */
    public function all()
    {
        return $this->get('user/keys');
    }

    /**
     * Shows deploy key for the authenticated user.
     *
     * @link http://developer.github.com/v3/repos/keys/
     *
     * @param string $id
     *
     * @return array
     */
    public function show($id)
    {
        return $this->get('user/keys/'.rawurlencode($id));
    }

    /**
     * Adds deploy key for the authenticated user.
     *
     * @link http://developer.github.com/v3/repos/keys/
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
            throw new MissingArgumentException(array('title', 'key'));
        }

        return $this->post('user/keys', $params);
    }

    /**
     * Updates deploy key for the authenticated user.
     *
     * @link http://developer.github.com/v3/repos/keys/
     *
     * @param string $id
     * @param array  $params
     *
     * @throws \Github\Exception\MissingArgumentException
     *
     * @return array
     */
    public function update($id, array $params)
    {
        if (!isset($params['title'], $params['key'])) {
            throw new MissingArgumentException(array('title', 'key'));
        }

        return $this->patch('user/keys/'.rawurlencode($id), $params);
    }

    /**
     * Removes deploy key for the authenticated user.
     *
     * @link http://developer.github.com/v3/repos/keys/
     *
     * @param string $id
     *
     * @return array
     */
    public function remove($id)
    {
        return $this->delete('user/keys/'.rawurlencode($id));
    }
}
