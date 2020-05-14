<?php

namespace Github\Tests\HttpClient\Plugin;

use Github\Client;
use Github\HttpClient\Plugin\Authentication;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * @dataProvider getAuthenticationData
     */
    public function testAuthenticationMethods($tokenOrLogin, $password, $method, $expectedHeader = null, $expectedUrl = null)
    {
        $request = new Request('GET', '/');
        $plugin = new Authentication($tokenOrLogin, $password, $method);

        /** @var Request $newRequest */
        $newRequest = null;
        $plugin->doHandleRequest($request, static function ($request) use (&$newRequest) {
            /** @var Request $newRequest */
            $newRequest = $request;
        }, static function () {
            throw new \RuntimeException('Did not expect plugin to call first');
        });

        $this->assertNotNull($newRequest);

        if ($expectedHeader) {
            $this->assertContains($expectedHeader, $newRequest->getHeader('Authorization'));
        } else {
            $this->assertEquals($expectedUrl, $newRequest->getUri()->__toString());
        }
    }

    public function getAuthenticationData()
    {
        return [
            ['login', 'password', Client::AUTH_HTTP_PASSWORD, sprintf('Basic %s', base64_encode('login'.':'.'password'))],
            ['access_token', null, Client::AUTH_HTTP_TOKEN, 'token access_token'],
            ['token', null, Client::AUTH_URL_TOKEN, null, '/?access_token=token'],
            ['access_token', null, Client::AUTH_ACCESS_TOKEN, 'token access_token'],
            ['client_id', 'client_secret', Client::AUTH_URL_CLIENT_ID, null, '/?client_id=client_id&client_secret=client_secret'],
            ['client_id', 'client_secret', Client::AUTH_CLIENT_ID, sprintf('Basic %s', base64_encode('client_id'.':'.'client_secret'))],
            ['jwt_token', null, Client::AUTH_JWT, 'Bearer jwt_token'],
        ];
    }
}
