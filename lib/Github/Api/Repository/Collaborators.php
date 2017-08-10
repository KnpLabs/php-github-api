<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;

/**
 * @link   http://developer.github.com/v3/repos/collaborators/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Collaborators extends AbstractApi
{
    /**
     * @link https://developer.github.com/v3/repos/collaborators/#list-collaborators
     *
     * @param $username
     * @param $repository
     * @param array $params
     * @return array|string
     */
    public function all($username, $repository, array $params = [])
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/collaborators', $params);
    }

    /**
     * @link https://developer.github.com/v3/repos/collaborators/#check-if-a-user-is-a-collaborator
     *
     * @param $username
     * @param $repository
     * @param $collaborator
     * @return array|string
     */
    public function check($username, $repository, $collaborator)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/collaborators/'.rawurlencode($collaborator));
    }

    /**
     * @link https://developer.github.com/v3/repos/collaborators/#add-user-as-a-collaborator
     *
     * @param $username
     * @param $repository
     * @param $collaborator
     * @param array $params
     * @return array|string
     */
    public function add($username, $repository, $collaborator, array $params = [])
    {
        return $this->put('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/collaborators/'.rawurlencode($collaborator), $params);
    }

    /**
     * @link https://developer.github.com/v3/repos/collaborators/#remove-user-as-a-collaborator
     *
     * @param $username
     * @param $repository
     * @param $collaborator
     * @return array|string
     */
    public function remove($username, $repository, $collaborator)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/collaborators/'.rawurlencode($collaborator));
    }
}
