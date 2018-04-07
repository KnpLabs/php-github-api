<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;

class Invitations extends AbstractApi
{
    public function all($username, $repository, array $params = [])
    {
        return $this->get('/repos/' . rawurlencode($username) . '/' . rawurlencode($repository) . '/invitations', array_merge(['page' => 1], $params));
    }

    public function update($username, $repository, $invitation, array $params)
    {
        return $this->patch('/repos/' . rawurlencode($username) . '/' . rawurlencode($repository) . '/invitations/' . rawurlencode($invitation), $params);
    }

    public function accept($invitation)
    {
        return $this->patch('/user/repository_invitations/' . rawurlencode($invitation));
    }

    public function decline($invitation)
    {
        return $this->delete('/user/repository_invitations/' . rawurlencode($invitation));
    }

    public function remove($username, $repository, $invitation)
    {
        return $this->delete('/repos/' . rawurlencode($username) . '/' . rawurlencode($repository) . '/invitations/' . rawurlencode($invitation));
    }
}
