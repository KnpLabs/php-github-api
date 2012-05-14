<?php

namespace Github\Tests\Functional;

use Github\Client;

class CommitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldRetrieveCommitsForRepositoryBranch()
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';
        $branch   = 'master';

        $github = new Client();
        $commits = $github->getCommitApi()->getBranchCommits($username, $repo, $branch);
        $commit = array_pop($commits);

        $this->assertArrayHasKey('url', $commit);
        $this->assertArrayHasKey('committer', $commit);
        $this->assertArrayHasKey('author', $commit);
        $this->assertArrayHasKey('commit', $commit);
        $this->assertArrayHasKey('sha', $commit);
    }

    /**
     * @test
     */
    public function shouldRetrieveCommitBySha()
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';

        $github = new Client();
        $commit = $github->getCommitApi()->getCommit($username, $repo, '6df3adf5bd16745299c6429e163265daed430fa1');

        $this->assertArrayHasKey('url', $commit);
        $this->assertArrayHasKey('committer', $commit);
        $this->assertArrayHasKey('author', $commit);
        $this->assertArrayHasKey('commit', $commit);
        $this->assertArrayHasKey('sha', $commit);
        $this->assertArrayHasKey('files', $commit);
    }

    /**
     * @test
     */
    public function shouldRetrieveCommitsForFile()
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';
        $branch   = 'api_v3';

        $github = new Client();
        $commits = $github->getCommitApi()->getFileCommits($username, $repo, $branch, 'composer.json');
        $commit = array_pop($commits);

        $this->assertArrayHasKey('url', $commit);
        $this->assertArrayHasKey('committer', $commit);
        $this->assertArrayHasKey('author', $commit);
        $this->assertArrayHasKey('commit', $commit);
        $this->assertArrayHasKey('sha', $commit);
    }
}
