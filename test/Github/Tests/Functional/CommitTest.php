<?php

namespace Github\Tests\Functional;

/**
 * @group functional
 */
class CommitTest extends TestCase
{
    /**
     * @test
     */
    public function shouldRetrieveCommitsForRepositoryBranch()
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';
        $branch   = 'master';

        $commits = $this->client->api('repo')->commits()->all($username, $repo, array('sha' => $branch));
        $commit  = array_pop($commits);

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

        $commit = $this->client->api('repo')->commits()->show($username, $repo, '6df3adf5bd16745299c6429e163265daed430fa1');

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
        $branch   = 'master';

        $commits = $this->client->api('repo')->commits()->all($username, $repo, array('sha' => $branch, 'path' => 'composer.json'));
        $commit = array_pop($commits);

        $this->assertArrayHasKey('url', $commit);
        $this->assertArrayHasKey('committer', $commit);
        $this->assertArrayHasKey('author', $commit);
        $this->assertArrayHasKey('commit', $commit);
        $this->assertArrayHasKey('sha', $commit);
    }
}
