<?php

namespace Github\Api\Enterprise;

use Github\Api\AbstractApi;

class UserAdmin extends AbstractApi
{
    /**
     * Suspend a user.
     *
     * @link https://docs.github.com/enterprise-server@3.14/rest/enterprise-admin/users#suspend-a-user
     *
     * @param string $username
     *
     * @return array
     */
    public function suspend($username)
    {
        return $this->put('/users/'.rawurldecode($username).'/suspended', ['Content-Length' => 0]);
    }

    /**
     * Unsuspend a user.
     *
     * @link https://docs.github.com/enterprise-server@3.14/rest/enterprise-admin/users#unsuspend-a-user
     *
     * @param string $username
     *
     * @return array
     */
    public function unsuspend($username)
    {
        return $this->delete('/users/'.rawurldecode($username).'/suspended');
    }
}
