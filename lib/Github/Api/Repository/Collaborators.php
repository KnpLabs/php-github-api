<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;

/**
 * @link   https://docs.github.com/rest/collaborators/collaborators
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Collaborators extends AbstractApi
{
    /**
     * @link https://docs.github.com/rest/collaborators/collaborators#list-repository-collaborators
     *
     * @param string $username
     * @param string $repository
     * @param array  $params
     *
     * @return array|string
     */
    public function all($username, $repository, array $params = [])
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/collaborators', $params);
    }

    /**
     * @link https://docs.github.com/rest/collaborators/collaborators#check-if-a-user-is-a-repository-collaborator
     *
     * @param string $username
     * @param string $repository
     * @param string $collaborator
     *
     * @return array|string
     */
    public function check($username, $repository, $collaborator)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/collaborators/'.rawurlencode($collaborator));
    }

    /**
     * @link https://docs.github.com/rest/collaborators/collaborators#add-a-repository-collaborator
     *
     * @param string $username
     * @param string $repository
     * @param string $collaborator
     * @param array  $params
     *
     * @return array|string
     */
    public function add($username, $repository, $collaborator, array $params = [])
    {
        return $this->put('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/collaborators/'.rawurlencode($collaborator), $params);
    }

    /**
     * @link https://docs.github.com/rest/collaborators/collaborators#remove-a-repository-collaborator
     *
     * @param string $username
     * @param string $repository
     * @param string $collaborator
     *
     * @return array|string
     */
    public function remove($username, $repository, $collaborator)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/collaborators/'.rawurlencode($collaborator));
    }

    /**
     * @link https://docs.github.com/rest/collaborators/collaborators#get-repository-permissions-for-a-user
     *
     * @param string $username
     * @param string $repository
     * @param string $collaborator
     *
     * @return array|string
     */
    public function permission($username, $repository, $collaborator)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/collaborators/'.rawurlencode($collaborator).'/permission');
    }
}
