<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;

/**
 * @link   http://developer.github.com/v3/repos/collaborators/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Collaborators extends AbstractApi
{
    public function all($username, $repository)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/collaborators');
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
