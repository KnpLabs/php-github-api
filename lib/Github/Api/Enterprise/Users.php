<?php

namespace Github\Api\Enterprise;

use Github\Api\AbstractApi;

class Users extends AbstractApi
{
    /**
     * Suspend a user
     *
     * @param string $username the username to suspend
     */
    public function suspend($username)
    {
        $this->put('users/' . rawurlencode($username) . '/suspended');
    }

    /**
     * Unsuspend a user
     *
     * @param string $username the username to unsuspend
     */
    public function unsuspend($username)
    {
        $this->delete('users/' . rawurlencode($username) . '/suspended');
    }
}