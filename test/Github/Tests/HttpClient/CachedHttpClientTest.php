<?php

namespace Github\Tests\HttpClient;

use Github\HttpClient\CachedHttpClient;
use Github\HttpClient\Message\Response;
use Github\HttpClient\Message\Request;

class CachedHttpClientTest extends HttpClientTest
{
    /**
     * @test
     */
    public function shouldCacheResponseAtFirstTime()
    {
        $cache = $this->getCacheMock();
        $httpClient = new CachedHttpClient(
            array('base_url' => ''),
            $this->getMock('Buzz\Client\ClientInterface', array('setTimeout', 'setVerifyPeer', 'send')),
            $cache
        );

        $cache->expects($this->once())->method('set')->with('test', new Response);

        $httpClient->get('test');
    }

    /**
     * @test
     */
    public function shouldGetCachedResponseWhileResourceNotModified()
    {
        $client = $this->getMock('Buzz\Client\ClientInterface', array('setTimeout', 'setVerifyPeer', 'send'));
        $client->expects($this->once())->method('send');

        $cache = $this->getCacheMock();

        $httpClient = new CachedHttpClient(
            array('base_url' => ''),
            $client,
            $cache
        );

        $cache->expects($this->once())->method('get')->with('test');

        $response = new Response;
        $response->addHeader('HTTP/1.1 304 Not Modified');

        $httpClient->request('test', array(), 'GET', array(), $response);
    }

    /**
     * @test
     */
    public function shouldRenewCacheWhenResourceHasChanged()
    {
        $client = $this->getMock('Buzz\Client\ClientInterface', array('setTimeout', 'setVerifyPeer', 'send'));
        $client->expects($this->once())->method('send');

        $cache = $this->getCacheMock();

        $httpClient = new CachedHttpClient(
            array('base_url' => ''),
            $client,
            $cache
        );

        $response = new Response;
        $response->addHeader('HTTP/1.1 200 OK');

        $cache->expects($this->once())->method('set')->with('test', $response);
        $cache->expects($this->once())->method('getModifiedSince')->with('test')->will($this->returnValue(1256953732));

        $httpClient->request('test', array(), 'GET', array(), $response);
    }

    public function getCacheMock()
    {
        return $this->getMock('Github\HttpClient\Cache\CacheInterface');
    }
}
