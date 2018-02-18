<?php

namespace Github\Tests\Api\PullRequest;

use Github\Api\PullRequest\Comments;
use Github\Tests\Api\TestCase;

class CommentsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllReviewCommentsForAPullRequest()
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
            ->with('/repos/octocat/Hello-World/pulls/12/comments')
            ->willReturn($expectedValue);

        $this->assertSame($expectedValue, $api->all('octocat', 'Hello-World', 12));
    }

    /**
     * @test
     */
    public function shouldGetAllReviewComments()
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
            ->with('/repos/octocat/Hello-World/pulls/comments')
            ->willReturn($expectedValue);

        $this->assertSame($expectedValue, $api->all('octocat', 'Hello-World'));
    }

    /**
     * @test
     */
    public function shouldShowReviewComment()
    {
        $expectedValue = [
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
        ];

        $api = $this->getApiMock();
        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/octocat/Hello-World/pulls/comments/1')
            ->willReturn($expectedValue);

        $this->assertSame($expectedValue, $api->show('octocat', 'Hello-World', 1));
    }

    /**
     * @test
     */
    public function shouldCreateReviewComment()
    {
        $expectedValue = [
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
        ];
        $data = [
            'commit_id' => '6dcb09b5b57875f334f61aebed695e2e4193db5e',
            'path' => 'file1.txt',
            'position' => 4,
            'body' => 'Nice change',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/octocat/Hello-World/pulls/1/comments', $data)
            ->willReturn($expectedValue);

        $this->assertSame($expectedValue, $api->create('octocat', 'Hello-World', 1, $data));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateReviewCommentWithoutCommitId()
    {
        $data = [
            'path' => 'file1.txt',
            'position' => 4,
            'body' => 'Nice change',
        ];

        $api = $this->getApiMock();
        $api
            ->expects($this->never())
            ->method('post')
        ;

        $api->create('octocat', 'Hello-World', 1, $data);
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateReviewCommentWithoutPath()
    {
        $data = [
            'commit_id' => '6dcb09b5b57875f334f61aebed695e2e4193db5e',
            'position' => 4,
            'body' => 'Nice change',
        ];

        $api = $this->getApiMock();
        $api
            ->expects($this->never())
            ->method('post')
        ;

        $api->create('octocat', 'Hello-World', 1, $data);
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateReviewCommentWithoutPosition()
    {
        $data = [
            'commit_id' => '6dcb09b5b57875f334f61aebed695e2e4193db5e',
            'path' => 'file1.txt',
            'body' => 'Nice change',
        ];

        $api = $this->getApiMock();
        $api
            ->expects($this->never())
            ->method('post')
        ;

        $api->create('octocat', 'Hello-World', 1, $data);
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateReviewCommentWithoutBody()
    {
        $data = [
            'commit_id' => '6dcb09b5b57875f334f61aebed695e2e4193db5e',
            'path' => 'file1.txt',
            'position' => 4,
        ];

        $api = $this->getApiMock();
        $api
            ->expects($this->never())
            ->method('post')
        ;

        $api->create('octocat', 'Hello-World', 1, $data);
    }

    /**
     * @test
     */
    public function shouldUpdateReviewComment()
    {
        $expectedValue = [
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
        ];
        $data = [
            'body' => 'Nice change',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/octocat/Hello-World/pulls/comments/1', $data)
            ->willReturn($expectedValue);

        $this->assertSame($expectedValue, $api->update('octocat', 'Hello-World', 1, $data));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotUpdateReviewCommentWithoutBody()
    {
        $expectedValue = [
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
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('patch')
        ;

        $this->assertSame($expectedValue, $api->update('octocat', 'Hello-World', 1, []));
    }

    /**
     * @test
     */
    public function shouldDeleteReviewComment()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/octocat/Hello-World/pulls/comments/1')
        ;

        $api->remove('octocat', 'Hello-World', 1);
    }

    protected function getApiClass()
    {
        return Comments::class;
    }
}
