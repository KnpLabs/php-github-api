<?php

namespace Github\Tests\Functional;

/**
 * @group functional
 */
class IssueCommentTest extends TestCase
{
    /**
     * @test
     */
    public function shouldRetrieveCommentsForIssue()
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';
        $issue    = 13;

        $comments = $this->client->api('issue')->comments()->all($username, $repo, $issue);
        $comment  = array_pop($comments);

        $this->assertArrayHasKey('id', $comment);
        $this->assertArrayHasKey('url', $comment);
        $this->assertArrayHasKey('body', $comment);
        $this->assertArrayHasKey('user', $comment);
        $this->assertArrayHasKey('created_at', $comment);
        $this->assertArrayHasKey('updated_at', $comment);

        return $comment['id'];
    }

    /**
     * @test
     * @depends shouldRetrieveCommentsForIssue
     */
    public function shouldRetrieveSingleComment($commentId)
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';

        $comment = $this->client->api('issue')->comments()->show($username, $repo, $commentId);

        $this->assertArrayHasKey('id', $comment);
        $this->assertArrayHasKey('url', $comment);
        $this->assertArrayHasKey('body', $comment);
        $this->assertArrayHasKey('user', $comment);
        $this->assertArrayHasKey('created_at', $comment);
        $this->assertArrayHasKey('updated_at', $comment);
    }

    /**
     * @test
     */
    public function shouldCreateCommentForIssue()
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';
        $issue    = 13;
        $params   = array('body' => '%');

        $comment = $this->client->api('issue')->comments()->create($username, $repo, $issue, $params);

        $this->assertArrayHasKey('id', $comment);
        $this->assertArrayHasKey('url', $comment);
        $this->assertArrayHasKey('body', $comment);
        $this->assertArrayHasKey('user', $comment);
        $this->assertArrayHasKey('created_at', $comment);
        $this->assertArrayHasKey('updated_at', $comment);

        return $comment['id'];
    }
    /**
     * @test
     * @depends shouldCreateCommentForIssue
     */
    public function shouldUpdateCommentByCommentId($commentId)
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';
        $params   = array('body' => 'test update');

        $comment = $this->client->api('issue')->comments()->update($username, $repo, $commentId, $params);

        $this->assertArrayHasKey('id', $comment);
        $this->assertArrayHasKey('url', $comment);
        $this->assertArrayHasKey('body', $comment);
        $this->assertArrayHasKey('user', $comment);
        $this->assertArrayHasKey('created_at', $comment);
        $this->assertArrayHasKey('updated_at', $comment);

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

        $this->client->api('issue')->comments()->remove($username, $repo, $commentId);
    }
}
