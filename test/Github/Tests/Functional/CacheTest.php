<?php

namespace Github\Tests\Functional;

use Cache\Adapter\PHPArray\ArrayCachePool;
use Github\Client;
use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\Psr7\stream_for;

/**
 * @group functional
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class CacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldServeCachedResponse()
    {
        $mockClient = new \Http\Mock\Client();
        $mockClient->addResponse($this->getCurrentUserResponse('nyholm'));
        $mockClient->addResponse($this->getCurrentUserResponse('octocat'));

        $github = Client::createWithHttpClient($mockClient);
        $github->addCache(new ArrayCachePool(), ['default_ttl'=>60]);

        $github->authenticate('fake_token_aaa', Client::AUTH_HTTP_TOKEN);
        $userA = $github->currentUser()->show();
        $this->assertEquals('nyholm', $userA['login']);

        $userB = $github->currentUser()->show();
        $this->assertEquals('nyholm', $userB['login']);
    }
    /**
     * @test
     */
    public function shouldVaryOnAuthorization()
    {
        $mockClient = new \Http\Mock\Client();
        $mockClient->addResponse($this->getCurrentUserResponse('nyholm'));
        $mockClient->addResponse($this->getCurrentUserResponse('octocat'));

        $github = Client::createWithHttpClient($mockClient);
        $github->addCache(new ArrayCachePool(), ['default_ttl'=>60]);

        $github->authenticate('fake_token_aaa', Client::AUTH_HTTP_TOKEN);
        $userA = $github->currentUser()->show();
        $this->assertEquals('nyholm', $userA['login']);

        $github->authenticate('fake_token_bbb', Client::AUTH_HTTP_TOKEN);
        $userB = $github->currentUser()->show();
        $this->assertEquals('octocat', $userB['login']);
    }

    private function getCurrentUserResponse($username)
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        $body = stream_for(json_encode([
          'login' => $username,
          'id' => 1,
          'avatar_url' => 'https://github.com/images/error/'.$username.'_happy.gif',
          'gravatar_id' => '',
          'url' => 'https://api.github.com/users/'.$username,
          'html_url' => 'https://github.com/'.$username,
          'followers_url' => 'https://api.github.com/users/'.$username.'/followers',
          'following_url' => 'https://api.github.com/users/'.$username.'/following{/other_user}',
          'gists_url' => 'https://api.github.com/users/'.$username.'/gists{/gist_id}',
          'starred_url' => 'https://api.github.com/users/'.$username.'/starred{/owner}{/repo}',
          'subscriptions_url' => 'https://api.github.com/users/'.$username.'/subscriptions',
          'organizations_url' => 'https://api.github.com/users/'.$username.'/orgs',
          'repos_url' => 'https://api.github.com/users/'.$username.'/repos',
          'events_url' => 'https://api.github.com/users/'.$username.'/events{/privacy}',
          'received_events_url' => 'https://api.github.com/users/'.$username.'/received_events',
          'type' => 'User',
          'site_admin' => false,
          'name' => 'monalisa '.$username,
          'company' => 'GitHub',
          'blog' => 'https://github.com/blog',
          'location' => 'San Francisco',
          'email' => $username.'@github.com',
          'hireable' => false,
          'bio' => 'There once was...',
          'public_repos' => 2,
          'public_gists' => 1,
          'followers' => 20,
          'following' => 0,
          'created_at' => '2008-01-14T04:33:35Z',
          'updated_at' => '2008-01-14T04:33:35Z',
          'total_private_repos' => 100,
          'owned_private_repos' => 100,
          'private_gists' => 81,
          'disk_usage' => 10000,
          'collaborators' => 8,
          'two_factor_authentication' => true,
          'plan' => [
                'name' => 'Medium',
            'space' => 400,
            'private_repos' => 20,
            'collaborators' => 0,
          ],
        ]));

        return new Response(200, $headers, $body);
    }
}
