<?php

namespace Github\Tests\Functional;

/**
 * @group functional
 */
class UsetTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowUserData()
    {
        $username = 'KnpLabs';

        $user = $this->client->api('user')->show($username);

        $this->assertArrayHasKey('id', $user);
        $this->assertEquals('KnpLabs', $user['login']);
        $this->assertEquals('Organization', $user['type']);
        $this->assertArrayHasKey('email', $user);
        $this->assertArrayHasKey('avatar_url', $user);
        $this->assertArrayHasKey('company', $user);
        $this->assertArrayHasKey('blog', $user);
        $this->assertArrayHasKey('public_repos', $user);
        $this->assertArrayHasKey('public_gists', $user);
        $this->assertArrayHasKey('followers', $user);
        $this->assertArrayHasKey('following', $user);
        $this->assertArrayHasKey('html_url', $user);
    }

    /**
     * @test
     * @expectedException \Github\Exception\RuntimeException
     */
    public function shouldNotUpdateUserWithoutAuthorization()
    {
        $this->client->api('current_user')->update(array('email' => 'leszek.prabucki@gmail.com'));
    }

    /**
     * @test
     */
    public function shouldGetUsersWhoUserIsFollowing()
    {
        $username = 'l3l0';

        $users = $this->client->api('user')->following($username);
        $user = array_pop($users);

        $this->assertArrayHasKey('id', $user);
        $this->assertArrayHasKey('login', $user);
    }

    /**
     * @test
     */
    public function shouldGetFollowersUsers()
    {
        $username = 'KnpLabs';

        $users = $this->client->api('user')->followers($username);
        $user = array_pop($users);

        $this->assertArrayHasKey('id', $user);
        $this->assertArrayHasKey('login', $user);
    }

    /**
     * @test
     * @expectedException \Github\Exception\RuntimeException
     */
    public function shouldNotFollowUserWithoutAuthorization()
    {
        $this->client->api('current_user')->follow()->follow('KnpLabs');
    }

    /**
     * @test
     * @expectedException \Github\Exception\RuntimeException
     */
    public function shouldNotUnfollowUserWithoutAuthorization()
    {
        $this->client->api('current_user')->follow()->unfollow('KnpLabs');
    }

    /**
     * @test
     */
    public function shouldGetReposBeingWatched()
    {
        $username = 'l3l0';

        $repos = $this->client->api('user')->watched($username);
        $repo = array_pop($repos);

        $this->assertArrayHasKey('id', $repo);
        $this->assertArrayHasKey('name', $repo);
        $this->assertArrayHasKey('description', $repo);
        $this->assertArrayHasKey('url', $repo);
        $this->assertArrayHasKey('has_wiki', $repo);
        $this->assertArrayHasKey('has_issues', $repo);
        $this->assertArrayHasKey('forks', $repo);
        $this->assertArrayHasKey('updated_at', $repo);
        $this->assertArrayHasKey('created_at', $repo);
        $this->assertArrayHasKey('pushed_at', $repo);
        $this->assertArrayHasKey('open_issues', $repo);
        $this->assertArrayHasKey('ssh_url', $repo);
        $this->assertArrayHasKey('git_url', $repo);
        $this->assertArrayHasKey('svn_url', $repo);
    }
}
