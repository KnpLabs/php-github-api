<?php

class Github_Tests_Functional_CommitTest extends PHPUnit_Framework_TestCase
{
    public function testGetCommits()
    {
        $username = 'ornicar';
        $repo     = 'php-github-api';
        $branch   = 'master';

        $github = new Github_Client();
        $commits = $github->getCommitApi()->getBranchCommits($username, $repo, $branch);
        $commit = array_pop($commits);

        $this->assertArrayHasKey('url', $commit);
    }
}
