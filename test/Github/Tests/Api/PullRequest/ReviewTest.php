<?php

namespace Github\Tests\Api\PullRequest;

use Github\Api\PullRequest\Comments;
use Github\Api\PullRequest\Review;
use Github\Tests\Api\TestCase;

class ReviewTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllReviewsForAPullRequest()
    {
        $expectedValue = [
            [
                'id' => 80,
                'user' => [
                    'login' => 'octocat',
                    'id' => 1,
                    'avatar_url' => 'https://github.com/images/error/octocat_happy.gif',
                    'gravatar_id' => '',
                    'url' => 'https://api.github.com/users/octocat',
                    'html_url' => 'https://github.com/octocat',
                    'followers_url' => 'https://api.github.com/users/octocat/followers',
                    'following_url' => 'https://api.github.com/users/octocat/following{/other_user}',
                    'gists_url' => 'https://api.github.com/users/octocat/gists{/gist_id}',
                    'starred_url' => 'https://api.github.com/users/octocat/starred{/owner}{/repo}',
                    'subscriptions_url' => 'https://api.github.com/users/octocat/subscriptions',
                    'organizations_url' => 'https://api.github.com/users/octocat/orgs',
                    'repos_url' => 'https://api.github.com/users/octocat/repos',
                    'events_url' => 'https://api.github.com/users/octocat/events{/privacy}',
                    'received_events_url' => 'https://api.github.com/users/octocat/received_events',
                    'type' => 'User',
                    'site_admin' => false,
                ],
                'body' => 'Here is the body for the review.',
                'commit_id' => 'ecdd80bb57125d7ba9641ffaa4d7d2c19d3f3091',
                'state' => 'APPROVED',
                'html_url' => 'https://github.com/octocat/Hello-World/pull/12#pullrequestreview-80',
                'pull_request_url' => 'https://api.github.com/repos/octocat/Hello-World/pulls/12',
                '_links' => [
                    'html' => [
                        'href' => 'https://github.com/octocat/Hello-World/pull/12#pullrequestreview-80',
                    ],
                    'pull_request' => [
                        'href' => 'https://api.github.com/repos/octocat/Hello-World/pulls/12',
                    ],
                ],
            ],
        ];

        $api = $this->getApiMock();
        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/octocat/Hello-World/pulls/12/reviews')
            ->willReturn($expectedValue);

        $this->assertSame($expectedValue, $api->all('octocat', 'Hello-World', 12));
    }

    /**
     * @test
     */
    public function shouldShowReview()
    {
        $expectedValue = [
            'id' => 80,
            'user' => [
                'login' => 'octocat',
                'id' => 1,
                'avatar_url' => 'https://github.com/images/error/octocat_happy.gif',
                'gravatar_id' => '',
                'url' => 'https://api.github.com/users/octocat',
                'html_url' => 'https://github.com/octocat',
                'followers_url' => 'https://api.github.com/users/octocat/followers',
                'following_url' => 'https://api.github.com/users/octocat/following{/other_user}',
                'gists_url' => 'https://api.github.com/users/octocat/gists{/gist_id}',
                'starred_url' => 'https://api.github.com/users/octocat/starred{/owner}{/repo}',
                'subscriptions_url' => 'https://api.github.com/users/octocat/subscriptions',
                'organizations_url' => 'https://api.github.com/users/octocat/orgs',
                'repos_url' => 'https://api.github.com/users/octocat/repos',
                'events_url' => 'https://api.github.com/users/octocat/events{/privacy}',
                'received_events_url' => 'https://api.github.com/users/octocat/received_events',
                'type' => 'User',
                'site_admin' => false,
            ],
            'body' => 'Here is the body for the review.',
            'commit_id' => 'ecdd80bb57125d7ba9641ffaa4d7d2c19d3f3091',
            'state' => 'APPROVED',
            'html_url' => 'https://github.com/octocat/Hello-World/pull/12#pullrequestreview-80',
            'pull_request_url' => 'https://api.github.com/repos/octocat/Hello-World/pulls/12',
            '_links' => [
                'html' => [
                    'href' => 'https://github.com/octocat/Hello-World/pull/12#pullrequestreview-80',
                ],
                'pull_request' => [
                    'href' => 'https://api.github.com/repos/octocat/Hello-World/pulls/12',
                ],
            ],
        ];

        $api = $this->getApiMock();
        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/octocat/Hello-World/pulls/12/reviews/80')
            ->willReturn($expectedValue);

        $this->assertSame($expectedValue, $api->show('octocat', 'Hello-World', 12, 80));
    }

    /**
     * @test
     */
    public function shouldDeleteReview()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/octocat/Hello-World/pulls/12/reviews/80')
        ;

        $api->remove('octocat', 'Hello-World', 12, 80);
    }

    /**
     * @test
     */
    public function shouldShowReviewComments()
    {
        $expectedValue = [
            [
                'url' => 'https://api.github.com/repos/octocat/Hello-World/pulls/comments/1',
                'id' => 1,
                'pull_request_review_id' => 42,
                'diff_hunk' => '@@ -16,33 +16,40 @@ public class Connection  => IConnection...',
                'path' => 'file1.txt',
                'position' => 1,
                'original_position' => 4,
                'commit_id' => '6dcb09b5b57875f334f61aebed695e2e4193db5e',
                'original_commit_id' => '9c48853fa3dc5c1c3d6f1f1cd1f2743e72652840',
                'user' => [
                    'login' => 'octocat',
                    'id' => 1,
                    'avatar_url' => 'https://github.com/images/error/octocat_happy.gif',
                    'gravatar_id' => '',
                    'url' => 'https://api.github.com/users/octocat',
                    'html_url' => 'https://github.com/octocat',
                    'followers_url' => 'https://api.github.com/users/octocat/followers',
                    'following_url' => 'https://api.github.com/users/octocat/following[/other_user]',
                    'gists_url' => 'https://api.github.com/users/octocat/gists[/gist_id]',
                    'starred_url' => 'https://api.github.com/users/octocat/starred[/owner][/repo]',
                    'subscriptions_url' => 'https://api.github.com/users/octocat/subscriptions',
                    'organizations_url' => 'https://api.github.com/users/octocat/orgs',
                    'repos_url' => 'https://api.github.com/users/octocat/repos',
                    'events_url' => 'https://api.github.com/users/octocat/events[/privacy]',
                    'received_events_url' => 'https://api.github.com/users/octocat/received_events',
                    'type' => 'User',
                    'site_admin' => false,
                ],
                'body' => 'Great stuff',
                'created_at' => '2011-04-14T16:00:49Z',
                'updated_at' => '2011-04-14T16:00:49Z',
                'html_url' => 'https://github.com/octocat/Hello-World/pull/1#discussion-diff-1',
                'pull_request_url' => 'https://api.github.com/repos/octocat/Hello-World/pulls/1',
                '_links' => [
                    'self' => [
                        'href' => 'https://api.github.com/repos/octocat/Hello-World/pulls/comments/1',
                    ],
                    'html' => [
                        'href' => 'https://github.com/octocat/Hello-World/pull/1#discussion-diff-1',
                    ],
                    'pull_request' => [
                        'href' => 'https://api.github.com/repos/octocat/Hello-World/pulls/1',
                    ],
                ],
            ],
        ];

        $api = $this->getApiMock();
        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/octocat/Hello-World/pulls/1/reviews/42/comments')
            ->willReturn($expectedValue);

        $this->assertSame($expectedValue, $api->comments('octocat', 'Hello-World', 1, 42));
    }

    /**
     * @test
     */
    public function shouldCreateReviewComment()
    {
        $data = [
            'event' => 'APPROVE',
            'body' => 'Nice change',
        ];

        $api = $this->getApiMock();
        $api
            ->expects($this->once())
            ->method('post')
            ->with('/repos/octocat/Hello-World/pulls/12/reviews')
        ;

        $api->create('octocat', 'Hello-World', 12, $data);
    }

    /**
     * @test
     */
    public function shouldCreatePendingReviewWithoutEvent()
    {
        $data = [
            'body' => 'Nice change',
        ];

        $api = $this->getApiMock();
        $api
            ->expects($this->once())
            ->method('post')
            ->with('/repos/octocat/Hello-World/pulls/12/reviews')
        ;

        $api->create('octocat', 'Hello-World', 12, $data);
    }

    /**
     * @test
     * @expectedException \Github\Exception\InvalidArgumentException
     */
    public function shouldNotCreateReviewWithInvalidEvent()
    {
        $data = [
            'event' => 'DISMISSED',
            'body' => 'Nice change',
        ];

        $api = $this->getApiMock();
        $api
            ->expects($this->never())
            ->method('post')
        ;

        $api->create('octocat', 'Hello-World', 12, $data);
    }

    /**
     * @test
     */
    public function shouldSubmitReviewComment()
    {
        $expectedValue = [
            'id' => 80,
            'user' => [
                'login' => 'octocat',
                'id' => 1,
                'avatar_url' => 'https://github.com/images/error/octocat_happy.gif',
                'gravatar_id' => '',
                'url' => 'https://api.github.com/users/octocat',
                'html_url' => 'https://github.com/octocat',
                'followers_url' => 'https://api.github.com/users/octocat/followers',
                'following_url' => 'https://api.github.com/users/octocat/following{/other_user}',
                'gists_url' => 'https://api.github.com/users/octocat/gists{/gist_id}',
                'starred_url' => 'https://api.github.com/users/octocat/starred{/owner}{/repo}',
                'subscriptions_url' => 'https://api.github.com/users/octocat/subscriptions',
                'organizations_url' => 'https://api.github.com/users/octocat/orgs',
                'repos_url' => 'https://api.github.com/users/octocat/repos',
                'events_url' => 'https://api.github.com/users/octocat/events{/privacy}',
                'received_events_url' => 'https://api.github.com/users/octocat/received_events',
                'type' => 'User',
                'site_admin' => false,
            ],
            'body' => 'Here is the body for the review.',
            'commit_id' => 'ecdd80bb57125d7ba9641ffaa4d7d2c19d3f3091',
            'state' => 'APPROVED',
            'html_url' => 'https://github.com/octocat/Hello-World/pull/12#pullrequestreview-80',
            'pull_request_url' => 'https://api.github.com/repos/octocat/Hello-World/pulls/12',
            '_links' => [
                'html' => [
                    'href' => 'https://github.com/octocat/Hello-World/pull/12#pullrequestreview-80',
                ],
                'pull_request' => [
                    'href' => 'https://api.github.com/repos/octocat/Hello-World/pulls/12',
                ],
            ],
        ];
        $data = [
            'event' => 'APPROVE',
            'body' => 'Nice change',
        ];

        $api = $this->getApiMock();
        $api
            ->expects($this->once())
            ->method('post')
            ->with('/repos/octocat/Hello-World/pulls/12/reviews/80/events')
            ->willReturn($expectedValue);

        $this->assertSame($expectedValue, $api->submit('octocat', 'Hello-World', 12, 80, $data));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotSubmitReviewWithoutEvent()
    {
        $data = [
            'body' => 'Nice change',
        ];

        $api = $this->getApiMock();
        $api
            ->expects($this->never())
            ->method('post')
        ;

        $api->submit('octocat', 'Hello-World', 12, 80, $data);
    }

    /**
     * @test
     * @expectedException \Github\Exception\InvalidArgumentException
     */
    public function shouldNotSubmitReviewWithInvalidEvent()
    {
        $data = [
            'event' => 'DISMISSED',
            'body' => 'Nice change',
        ];

        $api = $this->getApiMock();
        $api
            ->expects($this->never())
            ->method('post')
        ;

        $api->submit('octocat', 'Hello-World', 12, 80, $data);
    }

    /**
     * @test
     */
    public function shouldDismissReview()
    {
        $expectedValue = [
            'id' => 80,
            'user' => [
                'login' => 'octocat',
                'id' => 1,
                'avatar_url' => 'https://github.com/images/error/octocat_happy.gif',
                'gravatar_id' => '',
                'url' => 'https://api.github.com/users/octocat',
                'html_url' => 'https://github.com/octocat',
                'followers_url' => 'https://api.github.com/users/octocat/followers',
                'following_url' => 'https://api.github.com/users/octocat/following{/other_user}',
                'gists_url' => 'https://api.github.com/users/octocat/gists{/gist_id}',
                'starred_url' => 'https://api.github.com/users/octocat/starred{/owner}{/repo}',
                'subscriptions_url' => 'https://api.github.com/users/octocat/subscriptions',
                'organizations_url' => 'https://api.github.com/users/octocat/orgs',
                'repos_url' => 'https://api.github.com/users/octocat/repos',
                'events_url' => 'https://api.github.com/users/octocat/events{/privacy}',
                'received_events_url' => 'https://api.github.com/users/octocat/received_events',
                'type' => 'User',
                'site_admin' => false,
            ],
            'body' => 'Here is the body for the review.',
            'commit_id' => 'ecdd80bb57125d7ba9641ffaa4d7d2c19d3f3091',
            'state' => 'APPROVED',
            'html_url' => 'https://github.com/octocat/Hello-World/pull/12#pullrequestreview-80',
            'pull_request_url' => 'https://api.github.com/repos/octocat/Hello-World/pulls/12',
            '_links' => [
                'html' => [
                    'href' => 'https://github.com/octocat/Hello-World/pull/12#pullrequestreview-80',
                ],
                'pull_request' => [
                    'href' => 'https://api.github.com/repos/octocat/Hello-World/pulls/12',
                ],
            ],
        ];

        $api = $this->getApiMock();
        $api
            ->expects($this->once())
            ->method('put')
            ->with('/repos/octocat/Hello-World/pulls/12/reviews/80/dismissals')
            ->willReturn($expectedValue);

        $this->assertSame($expectedValue, $api->dismiss('octocat', 'Hello-World', 12, 80, 'Dismiss reason'));
    }

    protected function getApiClass()
    {
        return Review::class;
    }
}
