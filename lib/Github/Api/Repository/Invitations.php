<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\InvalidArgumentException;

/**
 * @link   https://developer.github.com/v3/repos/invitations/
 *
 * @author Daniel Camargo <daniel.camargo.eti@gmail.com>
 */
class Invitations extends AbstractApi
{
    /**
     * Represents the read permissions.
     *
     * @var string
     */
    const READ_PERMISSIONS = 'read';
    /**
     * Represents the write permissions.
     *
     * @var string
     */
    const PULL_PERMISSIONS = 'pull';
    /**
     * Represents the write permissions.
     *
     * @var string
     */
    const WRITE_PERMISSIONS = 'write';
    /**
     * Represents the write permissions.
     *
     * @var string
     */
    const PUSH_PERMISSIONS = 'push';
    /**
     * Represents the admin permissions.
     *
     * @var string
     */
    const ADMIN_PERMISSIONS = 'admin';

    /**
     * @link https://developer.github.com/v3/repos/collaborators/#add-user-as-a-collaborator
     *
     * Creates an invitation to the user to collaborate on a repo.
     *
     * @param string $username
     * @param string $repository
     * @param string $collaborator
     * @param string $permissions is optional and possible values are: pull, push, and admin.
     *
     * @return array
     */
    public function add($username, $repository, $collaborator, $permissions = null)
    {
        if (!in_array($permissions, [null, self::PULL_PERMISSIONS, self::PULL_PERMISSIONS, self::ADMIN_PERMISSIONS])) {
            throw new InvalidArgumentException('Invalid collaborator permissions: '.$permissions);
        }

        $params = [];
        if ($permissions) {
            $params['permissions'] = $permissions;
        }

        return $this->put('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/collaborators/'.rawurlencode($collaborator), $params);
    }

    /**
     * Returns a list of all currently open repository invitations. The invitations are returned sorted by creation
     * date, with the oldest invitations appearing first.
     *
     * @param string $username
     * @param string $repository
     * @param array  $params
     *
     * @return array
     */
    public function all($username, $repository, array $params = [])
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/invitations', array_merge(['page' => 1], $params));
    }

    /**
     * @link https://developer.github.com/v3/repos/invitations/#update-a-repository-invitation
     *
     * Updates the permissions of an invitations.
     *
     * @param string     $username
     * @param string     $repository
     * @param int|string $invitation
     * @param string     $permissions possible values are: read, write, and admin.
     *
     * @return array
     */
    public function updatePermissions($username, $repository, $invitation, $permissions)
    {
        if (!in_array($permissions, [self::READ_PERMISSIONS, self::WRITE_PERMISSIONS, self::ADMIN_PERMISSIONS])) {
            throw new InvalidArgumentException('Invalid invitation permissions: '.$permissions);
        }

        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/invitations/'.rawurlencode($invitation), ['permissions' => $permissions]);
    }

    /**
     * Accepts and invitation. Only the user to which the invitation was sent can perform this operation.
     *
     * @param int|string $invitation
     */
    public function accept($invitation)
    {
        $this->patch('/user/repository_invitations/'.rawurlencode($invitation));
    }

    /**
     * Declines and invitation. Only the user to which the invitation was sent can perform this operation.
     *
     * @param int|string $invitation
     */
    public function decline($invitation)
    {
        $this->delete('/user/repository_invitations/'.rawurlencode($invitation));
    }

    /**
     * @link https://developer.github.com/v3/repos/invitations/#delete-a-repository-invitation
     *
     * Removes an invitation. Only an admin can remove an invitation.
     *
     * @param string     $username
     * @param string     $repository
     * @param int|string $invitation
     */
    public function remove($username, $repository, $invitation)
    {
        $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/invitations/'.rawurlencode($invitation));
    }
}
