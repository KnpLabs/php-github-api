<?php

namespace Github\Tests\HttpClient\Plugin;

use Github\AuthMethod;
use Github\HttpClient\Plugin\Authentication;
use GuzzleHttp\Psr7\Request;
use Http\Promise\FulfilledPromise;
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
        $plugin->handleRequest($request, static function ($request) use (&$newRequest) {
            /** @var Request $newRequest */
            $newRequest = $request;

            return new FulfilledPromise('FOO');
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
            ['access_token', null, AuthMethod::ACCESS_TOKEN, 'token access_token'],
            ['client_id', 'client_secret', AuthMethod::CLIENT_ID, sprintf('Basic %s', base64_encode('client_id'.':'.'client_secret'))],
            ['jwt_token', null, AuthMethod::JWT, 'Bearer jwt_token'],
        ];
    }
}
