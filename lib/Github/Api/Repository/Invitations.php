<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;

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
    const WRITE_PERMISSIONS = 'write';
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
     * @param array  $params
     *
     * @return array
     */
    public function add($username, $repository, $collaborator, array $params = [])
    {
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
     * Updates the permissions of an invitations. Possible values are: read, write, and admin.
     *
     * @param string     $username
     * @param string     $repository
     * @param int|string $invitation
     * @param string     $permissions
     *
     * @return array
     */
    public function updatePermissions($username, $repository, $invitation, $permissions)
    {
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
