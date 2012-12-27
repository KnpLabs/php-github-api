<?php

namespace Github\Tests\Api;

use Github\Api\AbstractApi;

class AbstractApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldPassGETRequestToClient()
    {
        $expectedArray = array('value');

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->any())
            ->method('get')
            ->with('/path', array('param1' => 'param1value'), array('header1' => 'header1value'))
            ->will($this->returnValue($expectedArray));
        $client = $this->getClientMock();
        $client->setHttpClient($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertEquals($expectedArray, $api->get('/path', array('param1' => 'param1value'), array('header1' => 'header1value')));
    }

    /**
     * @test
     */
    public function shouldPassPOSTRequestToClient()
    {
        $expectedArray = array('value');

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->once())
            ->method('post')
            ->with('/path', array('param1' => 'param1value'), array('option1' => 'option1value'))
            ->will($this->returnValue($expectedArray));
        $client = $this->getClientMock();
        $client->setHttpClient($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertEquals($expectedArray, $api->post('/path', array('param1' => 'param1value'), array('option1' => 'option1value')));
    }

    /**
     * @test
     */
    public function shouldPassPATCHRequestToClient()
    {
        $expectedArray = array('value');

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->once())
            ->method('patch')
            ->with('/path', array('param1' => 'param1value'), array('option1' => 'option1value'))
            ->will($this->returnValue($expectedArray));
        $client = $this->getClientMock();
        $client->setHttpClient($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertEquals($expectedArray, $api->patch('/path', array('param1' => 'param1value'), array('option1' => 'option1value')));
    }

    /**
     * @test
     */
    public function shouldPassPUTRequestToClient()
    {
        $expectedArray = array('value');

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->once())
            ->method('put')
            ->with('/path', array('param1' => 'param1value'), array('option1' => 'option1value'))
            ->will($this->returnValue($expectedArray));
        $client = $this->getClientMock();
        $client->setHttpClient($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertEquals($expectedArray, $api->put('/path', array('param1' => 'param1value'), array('option1' => 'option1value')));
    }

    /**
     * @test
     */
    public function shouldPassDELETERequestToClient()
    {
        $expectedArray = array('value');

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->once())
            ->method('delete')
            ->with('/path', array('param1' => 'param1value'), array('option1' => 'option1value'))
            ->will($this->returnValue($expectedArray));
        $client = $this->getClientMock();
        $client->setHttpClient($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertEquals($expectedArray, $api->delete('/path', array('param1' => 'param1value'), array('option1' => 'option1value')));
    }

    protected function getAbstractApiObject($client)
    {
        return new AbstractApiTestInstance($client);
    }

    /**
     * @return \Github\Client
     */
    protected function getClientMock()
    {
        return new \Github\Client($this->getHttpMock());
    }

    /**
     * @return \Github\HttpClient\HttpClientInterface
     */
    protected function getHttpMock()
    {
        return $this->getMock('Github\HttpClient\HttpClient', array(), array(array(), $this->getHttpClientMock()));
    }

    protected function getHttpClientMock()
    {
        $mock = $this->getMock('Buzz\Client\ClientInterface', array('setTimeout', 'setVerifyPeer', 'send'));
        $mock
            ->expects($this->any())
            ->method('setTimeout')
            ->with(10);
        $mock
            ->expects($this->any())
            ->method('setVerifyPeer')
            ->with(false);
        $mock
            ->expects($this->any())
            ->method('send');

        return $mock;
    }
}

class AbstractApiTestInstance extends AbstractApi
{
    /**
     * {@inheritDoc}
     */
    public function get($path, array $parameters = array(), $requestHeaders = array())
    {
        return $this->client->getHttpClient()->get($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritDoc}
     */
    public function post($path, array $parameters = array(), $requestHeaders = array())
    {
        return $this->client->getHttpClient()->post($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritDoc}
     */
    public function patch($path, array $parameters = array(), $requestHeaders = array())
    {
        return $this->client->getHttpClient()->patch($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritDoc}
     */
    public function put($path, array $parameters = array(), $requestHeaders = array())
    {
        return $this->client->getHttpClient()->put($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($path, array $parameters = array(), $requestHeaders = array())
    {
        return $this->client->getHttpClient()->delete($path, $parameters, $requestHeaders);
    }
}
