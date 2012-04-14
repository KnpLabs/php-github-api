<?php

namespace Github\Tests\Functional;

use Github\Client;

class CommitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetCommits()
    {
        $username = 'ornicar';
        $repo     = 'php-github-api';
        $branch   = 'master';

        $github = new Client();
        $commits = $github->getCommitApi()->getBranchCommits($username, $repo, $branch);
        $commit = array_pop($commits);

        $this->assertArrayHasKey('url', $commit);
    }
}
