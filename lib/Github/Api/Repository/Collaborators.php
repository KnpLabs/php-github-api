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
     * Get all collaborators for a repository
     * @link https://developer.github.com/v3/repos/collaborators/#list
     *
     * @param  string $username   the username
     * @param  string $repository the repository
     * @param  int    $page       the page
     * @param  int    $perPage    the number of results by page
     *
     * @return array list of collaborators for the repository
     */
    public function all($username, $repository, $page = 1, $perPage = 30)
    {
        $parameters = array(
            'page'     => $page,
            'per_page' => $perPage
        );

        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/collaborators', $parameters);
    }

    public function check($username, $repository, $collaborator)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/collaborators/'.rawurlencode($collaborator));
    }

    public function add($username, $repository, $collaborator)
    {
        return $this->put('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/collaborators/'.rawurlencode($collaborator));
    }

    public function remove($username, $repository, $collaborator)
    {
        return $this->delete('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/collaborators/'.rawurlencode($collaborator));
    }
}
