<?php

namespace Github\Tests\HttpClient;

use Github\HttpClient\CachedHttpClient;
use Github\HttpClient\Message\Response;

class CachedHttpClientTest extends HttpClientTest
{
    /**
     * @test
     */
    public function shouldCacheResponseAtFirstTime()
    {
        $cache = $this->getCacheMock();

        $httpClient = new TestCachedHttpClient(
            array('base_url' => ''),
            $this->getMock('Buzz\Client\ClientInterface', array('setTimeout', 'setVerifyPeer', 'send'))
        );
        $httpClient->setCache($cache);

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

        $response = new Response;
        $response->addHeader('HTTP/1.1 304 Not Modified');

        $httpClient = new TestCachedHttpClient(
            array('base_url' => ''),
            $client
        );
        $httpClient->setCache($cache);
        $httpClient->fakeResponse = $response;

        $cache->expects($this->once())->method('get')->with('test');

        $httpClient->get('test');
    }

    /**
     * @test
     */
    public function shouldRenewCacheWhenResourceHasChanged()
    {
        $client = $this->getMock('Buzz\Client\ClientInterface', array('setTimeout', 'setVerifyPeer', 'send'));
        $client->expects($this->once())->method('send');

        $cache = $this->getCacheMock();

        $response = new Response;
        $response->addHeader('HTTP/1.1 200 OK');

        $httpClient = new TestCachedHttpClient(
            array('base_url' => ''),
            $client
        );
        $httpClient->setCache($cache);
        $httpClient->fakeResponse = $response;

        $cache->expects($this->once())->method('set')->with('test', $response);
        $cache->expects($this->once())->method('getModifiedSince')->with('test')->will($this->returnValue(1256953732));

        $httpClient->get('test');
    }

    public function getCacheMock()
    {
        return $this->getMock('Github\HttpClient\Cache\CacheInterface');
    }
}

class TestCachedHttpClient extends CachedHttpClient
{
    public $fakeResponse;

    protected function createResponse()
    {
        return $this->fakeResponse ?: new Response();
    }
}
