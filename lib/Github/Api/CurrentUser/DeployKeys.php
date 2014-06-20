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
     * List deploy keys for the authenticated user
     * @link http://developer.github.com/v3/repos/keys/
     *
     * @param  int    $page       the page
     * @param  int    $perPage    the number of results by page
     *
     * @return array
     */
    public function all($page=1, $perPage=30)
    {
        $parameters = array(
            'page' => $page,
            'per_page' => $perPage
        );

        return $this->get('user/keys');
    }

    /**
     * Shows deploy key for the authenticated user
     * @link http://developer.github.com/v3/repos/keys/
     *
     * @param  string $id
     * @return array
     */
    public function show($id)
    {
        return $this->get('user/keys/'.rawurlencode($id));
    }

    /**
     * Adds deploy key for the authenticated user
     * @link http://developer.github.com/v3/repos/keys/
     *
     * @param  array $params
     * @return array
     *
     * @throws MissingArgumentException
     */
    public function create(array $params)
    {
        if (!isset($params['title'], $params['key'])) {
            throw new MissingArgumentException(array('title', 'key'));
        }

        return $this->post('user/keys', $params);
    }

    /**
     * Updates deploy key for the authenticated user
     * @link http://developer.github.com/v3/repos/keys/
     *
     * @param  string $id
     * @param  array  $params
     * @return array
     *
     * @throws MissingArgumentException
     */
    public function update($id, array $params)
    {
        if (!isset($params['title'], $params['key'])) {
            throw new MissingArgumentException(array('title', 'key'));
        }

        return $this->patch('user/keys/'.rawurlencode($id), $params);
    }

    /**
     * Removes deploy key for the authenticated user
     * @link http://developer.github.com/v3/repos/keys/
     *
     * @param  string $id
     * @return array
     */
    public function remove($id)
    {
        return $this->delete('user/keys/'.rawurlencode($id));
    }
}
