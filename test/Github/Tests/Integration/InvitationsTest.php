<?php

namespace Github\Tests\Integration;

use function Clue\StreamFilter\remove;
use Github\Client;

/**
 * @group integration
 */
class InvitationsTest extends TestCase
{
    private $username;
    private $repo;

    /** @var Client */
    private $invitedClient;

    public function setUp()
    {
        parent::setUp();
        $this->username = getenv("GITHUB_USER_1");
        $this->repo     = getenv("GITHUB_REPO_1");

        $this->invitedClient = new Client();
        $this->auth($this->invitedClient, 2);
    }

    /**
     * @test
     */
    public function test()
    {
        $invitations  = $this->listInvitations();
        $originalSize = count($invitations);

        $this->client->repo()->collaborators()->add($this->username, $this->repo, getenv('GITHUB_USER_2'));
        $invitations = $this->listInvitations();
        $this->assertEquals($originalSize + 1, count($invitations));
        $invitation = $invitations[$originalSize];

        $collaborators      = $this->client->repo()->collaborators()->all($this->username, $this->repo);
        $collaboratorsCount = count($collaborators);

        $this->accept($invitation['id']);
        $collaborators = $this->client->repo()->collaborators()->all($this->username, $this->repo);
        $this->assertEquals($collaboratorsCount + 1, count($collaborators));

        $this->client->repo()->collaborators()->remove($this->username, $this->repo, getenv('GITHUB_USER_2'));

        $this->client->repo()->collaborators()->add($this->username, $this->repo, getenv('GITHUB_USER_2'));
        $invitations = $this->listInvitations();
        $this->assertEquals($originalSize + 1, count($invitations));
        $invitation = $invitations[$originalSize];

        $this->decline($invitation['id']);
        $invitations = $this->listInvitations();
        $this->assertEquals($originalSize, count($invitations));

        $this->client->repo()->collaborators()->add($this->username, $this->repo, getenv('GITHUB_USER_2'));
        $invitations = $this->listInvitations();
        $this->assertEquals($originalSize + 1, count($invitations));
        $invitation = $invitations[$originalSize];

        $this->updateInvitation($invitation['id']);
        $invitations = $this->listInvitations();
        $invitation  = $invitations[$originalSize];
        $this->assertEquals("read", $invitation['permissions']);

        $this->removeInvitation($invitation['id']);
        $invitations = $this->listInvitations();
        $this->assertEquals($originalSize, count($invitations));
    }

    public function decline($id)
    {
        return $this->invitedClient->repo()->invitations()->decline($id);
    }

    public function accept($id)
    {
        return $this->invitedClient->repo()->invitations()->accept($id);
    }

    public function updateInvitation($id)
    {
        return $this->client->repo()->invitations()->update($this->username, $this->repo, $id, [
            'permissions' => 'read',
        ]);
    }

    public function listInvitations()
    {
        return $this->client->repo()->invitations()->all($this->username, $this->repo);
    }

    public function removeInvitation($id)
    {
        return $this->client->repo()->invitations()->remove($this->username, $this->repo, $id);
    }
}
