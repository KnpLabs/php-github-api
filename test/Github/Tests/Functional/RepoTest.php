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
        $contributors = $github->getRepoApi()->getRepoContributors($username, $repo);
        $contributor = array_pop($contributors);

        $this->assertArrayHasKey('url', $contributor);
        $this->assertArrayHasKey('gravatar_id', $contributor);
        $this->assertArrayHasKey('contributions', $contributor);
        $this->assertArrayHasKey('avatar_url', $contributor);
        $this->assertArrayHasKey('login', $contributor);
        $this->assertArrayHasKey('id', $contributor);
    }
}
