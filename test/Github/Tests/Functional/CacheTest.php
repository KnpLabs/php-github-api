<?php

namespace Github\Tests\Functional;

use Github\AuthMethod;
use Github\Client;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

/**
 * @group functional
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class CacheTest extends \PHPUnit\Framework\TestCase
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
        $github->addCache(new ArrayAdapter(), ['default_ttl'=>600]);

        $github->authenticate('fake_token_aaa', AuthMethod::ACCESS_TOKEN);
        $userA = $github->currentUser()->show();
        $this->assertEquals('nyholm', $userA['login']);

        $userB = $github->currentUser()->show();
        $this->assertEquals('nyholm', $userB['login'], 'Two request following each other should be cached.');
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
        $github->addCache(new ArrayAdapter(), ['default_ttl'=>600]);

        $github->authenticate('fake_token_aaa', AuthMethod::ACCESS_TOKEN);
        $userA = $github->currentUser()->show();
        $this->assertEquals('nyholm', $userA['login']);

        $github->authenticate('fake_token_bbb', AuthMethod::ACCESS_TOKEN);
        $userB = $github->currentUser()->show();
        $this->assertEquals('octocat', $userB['login'], 'We must vary on the Authorization header.');
    }

    private function getCurrentUserResponse($username)
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        $body = \GuzzleHttp\Psr7\stream_for(json_encode([
            'login' => $username,
        ]));

        return new Response(200, $headers, $body);
    }
}
