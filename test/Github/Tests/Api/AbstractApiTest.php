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
        $response = $this->getResponseMock($expectedArray);

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->once())
            ->method('request')
            ->with('/path', array('param1' => 'param1value'), 'GET', array('header1' => 'header1value'))
            ->will($this->returnValue($response));

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
            ->method('request')
            ->with('/path', array('param1' => 'param1value'), 'POST', array('option1' => 'option1value'))
            ->will($this->returnValue($this->getResponseMock($expectedArray)));

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
            ->method('request')
            ->with('/path', array('param1' => 'param1value'), 'PATCH', array('option1' => 'option1value'))
            ->will($this->returnValue($this->getResponseMock($expectedArray)));
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
            ->method('request')
            ->with('/path', array('param1' => 'param1value'), 'PUT', array('option1' => 'option1value'))
            ->will($this->returnValue($this->getResponseMock($expectedArray)));
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
            ->method('request')
            ->with('/path', array('param1' => 'param1value'), 'DELETE', array('option1' => 'option1value'))
            ->will($this->returnValue($this->getResponseMock($expectedArray)));
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
        return $this->getMock('Github\HttpClient\HttpClientInterface', array(), array(array(), $this->getHttpClientMock()));
    }

    protected function getHttpClientMock()
    {
        $mock = $this->getMock('Buzz\Client\ClientInterface', array('setTimeout', 'setVerifyPeer', 'send', 'request'));
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

    protected function getResponseMock($expectedValue, $times = 1)
    {
        $mock = $this
            ->getMockBuilder('Github\\HttpClient\\ResponseInterface')
            ->setMethods(array(
                'getContent', 'getPagination',
                'isNotModified', 'getHeaderAsString',
                'getStatusCode', 'getRawBody',
                'getAdapterResponse'
            ))
            ->getMock()
        ;

        $mock
            ->expects($this->exactly($times))
            ->method('getContent')
            ->will($this->returnValue($expectedValue))
        ;

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
        return $this->client->executeRequest('GET', $path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritDoc}
     */
    public function post($path, array $parameters = array(), $requestHeaders = array())
    {
        return $this->client->executeRequest('POST', $path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritDoc}
     */
    public function patch($path, array $parameters = array(), $requestHeaders = array())
    {
        return $this->client->executeRequest('PATCH', $path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritDoc}
     */
    public function put($path, array $parameters = array(), $requestHeaders = array())
    {
        return $this->client->executeRequest('PUT', $path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($path, array $parameters = array(), $requestHeaders = array())
    {
        return $this->client->executeRequest('DELETE', $path, $parameters, $requestHeaders);
    }
}
