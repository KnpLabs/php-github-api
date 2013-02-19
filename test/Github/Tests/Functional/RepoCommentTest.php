<?php

namespace Github\Tests\Functional;

/**
 * @group functional
 */
class RepoCommentTest extends TestCase
{
    /**
     * @test
     */
    public function shouldRetrieveComments()
    {
        $username = 'fabpot';
        $repo     = 'Twig';

        $comments = $this->client->api('repo')->comments()->all($username, $repo);
        $comment  = array_pop($comments);

        $this->assertArrayHasKey('line', $comment);
        $this->assertArrayHasKey('body', $comment);
        $this->assertArrayHasKey('user', $comment);
        $this->assertArrayHasKey('created_at', $comment);
        $this->assertArrayHasKey('id', $comment);
        $this->assertArrayHasKey('url', $comment);
    }

    /**
     * @test
     */
    public function shouldRetrieveCommentsForCommit()
    {
        $username = 'fabpot';
        $repo     = 'Twig';
        $sha      = '3506cfad1d946f4a87e8c55849a18044efe2d5dc';

        $comments = $this->client->api('repo')->comments()->all($username, $repo, $sha);
        $comment  = array_pop($comments);

        $this->assertArrayHasKey('line', $comment);
        $this->assertArrayHasKey('body', $comment);
        $this->assertArrayHasKey('user', $comment);
        $this->assertArrayHasKey('created_at', $comment);
        $this->assertArrayHasKey('id', $comment);
        $this->assertArrayHasKey('url', $comment);
    }

    /**
     * @test
     */
    public function shouldCreateCommentForCommit()
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';
        $sha      = '22655813eb54e7d4e21545e396f919bcd245b50d';
        $params   = array('body' => '%');

        $comment = $this->client->api('repo')->comments()->create($username, $repo, $sha, $params);

        $this->assertArrayHasKey('created_at', $comment);
        $this->assertArrayHasKey('updated_at', $comment);
        $this->assertArrayHasKey('url', $comment);
        $this->assertArrayHasKey('id', $comment);
        $this->assertArrayHasKey('body', $comment);
        $this->assertArrayHasKey('user', $comment);

        return $comment['id'];
    }

    /**
     * @test
     * @depends shouldCreateCommentForCommit
     */
    public function shouldShowCommentByCommentId($commentId)
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';

        $comment = $this->client->api('repo')->comments()->show($username, $repo, $commentId);

        $this->assertArrayHasKey('created_at', $comment);
        $this->assertArrayHasKey('updated_at', $comment);
        $this->assertArrayHasKey('url', $comment);
        $this->assertArrayHasKey('id', $comment);
        $this->assertArrayHasKey('body', $comment);
        $this->assertArrayHasKey('user', $comment);

        return $comment['id'];
    }

    /**
     * @test
     * @depends shouldShowCommentByCommentId
     */
    public function shouldUpdateCommentByCommentId($commentId)
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';
        $params   = array('body' => 'test update');

        $comment = $this->client->api('repo')->comments()->update($username, $repo, $commentId, $params);

        $this->assertArrayHasKey('created_at', $comment);
        $this->assertArrayHasKey('updated_at', $comment);
        $this->assertArrayHasKey('url', $comment);
        $this->assertArrayHasKey('id', $comment);
        $this->assertArrayHasKey('body', $comment);
        $this->assertArrayHasKey('user', $comment);

        return $comment['id'];
    }

    /**
     * @test
     * @depends shouldUpdateCommentByCommentId
     */
    public function shouldRemoveCommentByCommentId($commentId)
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';

        $this->client->api('repo')->comments()->remove($username, $repo, $commentId);
    }
}
