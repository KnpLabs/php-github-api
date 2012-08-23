<?php

namespace Github\Tests\Functional;

use Github\Client;

class RepoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldRetrieveContributorsList()
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';

        $github = new Client();
        $contributors = $github->api('repo')->contributors($username, $repo);
        $contributor = array_pop($contributors);

        $this->assertArrayHasKey('url', $contributor);
        $this->assertArrayHasKey('gravatar_id', $contributor);
        $this->assertArrayHasKey('contributions', $contributor);
        $this->assertArrayHasKey('avatar_url', $contributor);
        $this->assertArrayHasKey('login', $contributor);
        $this->assertArrayHasKey('id', $contributor);
    }

    /**
     * @test
     */
    public function shouldShowRepo()
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';

        $github = new Client();
        $repo = $github->api('repo')->show($username, $repo);

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
