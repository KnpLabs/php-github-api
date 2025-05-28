<?php

namespace ArgoCD\Tests\HttpClient\Plugin;

use ArgoCD\HttpClient\Plugin\PathPrepend;
use GuzzleHttp\Psr7\Request;
use Http\Promise\FulfilledPromise;
use PHPUnit\Framework\TestCase;

/**
 * @author Nils Adermann <naderman@naderman.de>
 */
class PathPrependTest extends TestCase
{
    /**
     * @dataProvider uris
     */
    public function testPathIsPrepended($uri, $expectedPath)
    {
        $request = new Request('GET', $uri);
        $plugin = new PathPrepend('/api/v3');

        $newRequest = null;
        $plugin->handleRequest($request, function ($request) use (&$newRequest) {
            $newRequest = $request;

            return new FulfilledPromise('FOO');
        }, function () {
            throw new \RuntimeException('Did not expect plugin to call first');
        });

        $this->assertEquals($expectedPath, $newRequest->getUri()->getPath());
    }

    public static function uris()
    {
        return [
            ['http://example.com/foo/bar/api', '/api/v3/foo/bar/api'],
            ['http://example.com/api/v3/foo/bar/api', '/api/v3/foo/bar/api'],
        ];
    }
}
