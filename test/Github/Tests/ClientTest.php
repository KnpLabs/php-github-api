<?php

namespace Github\Tests;

use Github\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testInstanciateWithoutHttpClient()
    {
        $client = new Client();

        $this->assertInstanceOf('Github\HttpClient\HttpClientInterface', $client->getHttpClient());
    }

    public function testInstanciateWithHttpClient()
    {
        $httpClient = $this->getHttpClientMock();
        $client = new Client($httpClient);

        $this->assertEquals($httpClient, $client->getHttpClient());
    }

    public function testAuthenticate()
    {
        $login = 'login';
        $secret = 'secret';
        $method = 'method';

        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->exactly(2))
            ->method('setOption')
            ->will($this->returnValue($httpClient));

        $client = new Client($httpClient);
        $client->authenticate($login, $secret, $method);
    }

    public function testDeauthenticate()
    {
        $client = $this->getClientMockBuilder()
            ->setMethods(array('authenticate'))
            ->getMock();
        $client->expects($this->once())
            ->method('authenticate')
            ->with(null, null, null);

        $client->deAuthenticate();
    }

    public function testGet()
    {
        $path      = '/some/path';
        $parameters = array('a' => 'b');
        $options    = array('c' => 'd');

        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())
            ->method('get')
            ->with($path, $parameters, $options);

        $client = new Client($httpClient);
        $client->get($path, $parameters, $options);
    }

    public function testPost()
    {
        $path      = '/some/path';
        $parameters = array('a' => 'b');
        $options    = array('c' => 'd');

        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())
            ->method('post')
            ->with($path, $parameters, $options);

        $client = new Client($httpClient);
        $client->post($path, $parameters, $options);
    }

    public function testDefaultApi()
    {
        $client = new Client();

        $this->assertInstanceOf('Github\Api\User', $client->getUserApi());
    }

    public function testInjectApi()
    {
        $client = new Client();

        $userApiMock = $this->getMockBuilder('Github\Api\ApiInterface')
            ->getMock();

        $client->setApi('user', $userApiMock);

        $this->assertSame($userApiMock, $client->getUserApi());
    }

    protected function getClientMockBuilder()
    {
        return $this->getMockBuilder('Github\Client')
            ->disableOriginalConstructor();
    }

    protected function getHttpClientMock()
    {
        return $this->getMock('Github\HttpClient\HttpClientInterface');
    }
}
