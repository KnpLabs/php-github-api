<?php

namespace Github\Tests\Api\PullRequest;

use Github\Api\PullRequest\ReviewRequest;
use Github\Tests\Api\TestCase;

class ReviewRequestTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllReviewRequestsForAPullRequest()
    {
        $expectedValue = [
            ['id' => 80],
            ['id' => 81],
        ];

        $api = $this->getApiMock();
        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/octocat/Hello-World/pulls/12/requested_reviewers')
            ->willReturn($expectedValue);

        $this->assertSame($expectedValue, $api->all('octocat', 'Hello-World', 12));
    }

    /**
     * @test
     */
    public function shouldCreateReviewRequest()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/octocat/Hello-World/pulls/12/requested_reviewers', ['reviewers' => ['testuser']])
        ;

        $api->create('octocat', 'Hello-World', 12, ['testuser']);
    }

    /**
     * @test
     */
    public function shouldDeleteReviewRequest()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/octocat/Hello-World/pulls/12/requested_reviewers', ['reviewers' => ['testuser']])
        ;

        $api->remove('octocat', 'Hello-World', 12, ['testuser']);
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return ReviewRequest::class;
    }
}
