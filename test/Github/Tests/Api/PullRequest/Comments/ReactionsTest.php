<?php

namespace Github\Tests\Api\PullRequest\Comments;

use Github\Exception\MissingArgumentException;
use Github\Tests\Api\TestCase;

class ReactionsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllPullRequestReviewCommentReactions()
    {
        $expectedValue = [['reaction1data'], ['reaction2data']];
        $parameters = ['content' => 'eyes'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/pulls/comments/123/reactions', $parameters)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', 123, $parameters));
    }

    /**
     * @test
     */
    public function shouldNotCreatePullRequestReviewCommentReactionWithoutContent()
    {
        $this->expectException(MissingArgumentException::class);

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', 123, []);
    }

    /**
     * @test
     */
    public function shouldCreatePullRequestReviewCommentReaction()
    {
        $expectedValue = ['reaction1data'];
        $data = ['content' => 'eyes'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/pulls/comments/123/reactions', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', 123, $data));
    }

    /**
     * @test
     */
    public function shouldRemovePullRequestReviewCommentReaction()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/pulls/comments/123/reactions/456')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 123, 456));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\PullRequest\Comments\Reactions::class;
    }
}
