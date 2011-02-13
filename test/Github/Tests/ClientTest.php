<?php

class Github_Tests_ClientTest extends PHPUnit_Framework_TestCase
{
    public function testInstanciateWithoutHttpClient()
    {
        $client = new Github_Client();

        $this->assertInstanceOf('Github_HttpClientInterface', $client->getHttpClient());
    }

    public function testInstanciateWithHttpClient()
    {
        $httpClient = $this->getHttpClientMock();
        $client = new Github_Client($httpClient);

        $this->assertEquals($httpClient, $client->getHttpClient());
    }

    public function testAuthenticate()
    {
        $login = 'login';
        $secret = 'secret';
        $method = 'method';

        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->exactly(3))
            ->method('setOption')
            ->will($this->returnValue($httpClient));

        $client = $this->getClientMockBuilder()
            ->setMethods(array('getHttpClient'))
            ->getMock();
        $client->expects($this->once())
            ->method('getHttpClient')
            ->with()
            ->will($this->returnValue($httpClient));

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

        $client = $this->getClientMockBuilder()
            ->setMethods(array('getHttpClient'))
            ->getMock();
        $client->expects($this->once())
            ->method('getHttpClient')
            ->with()
            ->will($this->returnValue($httpClient));

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

        $client = $this->getClientMockBuilder()
            ->setMethods(array('getHttpClient'))
            ->getMock();
        $client->expects($this->once())
            ->method('getHttpClient')
            ->with()
            ->will($this->returnValue($httpClient));

        $client->post($path, $parameters, $options);
    }

    public function testDefaultApi()
    {
        $client = new Github_Client();

        $this->assertInstanceOf('Github_Api_User', $client->getUserApi());
    }

    public function testInjectApi()
    {
        $client = new Github_Client();

        $userApiMock = $this->getMockBuilder('Github_ApiInterface')
            ->getMock();

        $client->setApi('user', $userApiMock);

        $this->assertSame($userApiMock, $client->getUserApi());
    }

    protected function getClientMockBuilder()
    {
        return $this->getMockBuilder('Github_Client')
            ->disableOriginalConstructor();
    }

    protected function getHttpClientMock()
    {
        return $this->getMockBuilder('Github_HttpClientInterface')
            ->getMock();
    }
}
