<?php

namespace Github\Tests\Api;

use Github\Api\AbstractApi;
use GuzzleHttp\Psr7\Response;
use ReflectionMethod;

class AbstractApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldPassGETRequestToClient()
    {
        $expectedArray = array('value');

        $httpClient = $this->getHttpMethodsMock(array('get'));
        $httpClient
            ->expects($this->any())
            ->method('get')
            ->with('/path?param1=param1value', array('header1' => 'header1value'))
            ->will($this->returnValue($this->getPSR7Response($expectedArray)));
        $client = $this->getMockBuilder(\Github\Client::class)
            ->setMethods(array('getHttpClient'))
            ->getMock();
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $api = $this->getAbstractApiObject($client);

        $method = $this->getMethodReflection($api, 'get');

        $this->assertEquals($expectedArray, $method->invokeArgs($api, ['/path', ['param1' => 'param1value'], ['header1' => 'header1value']]));
    }

    /**
     * @test
     */
    public function shouldPassPOSTRequestToClient()
    {
        $expectedArray = array('value');

        $httpClient = $this->getHttpMethodsMock(array('post'));
        $httpClient
            ->expects($this->once())
            ->method('post')
            ->with('/path', array('option1' => 'option1value'), json_encode(array('param1' => 'param1value')))
            ->will($this->returnValue($this->getPSR7Response($expectedArray)));

        $client = $this->getMockBuilder(\Github\Client::class)
            ->setMethods(array('getHttpClient'))
            ->getMock();
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $api = $this->getAbstractApiObject($client);
        $method = $this->getMethodReflection($api, 'post');

        $this->assertEquals($expectedArray, $method->invokeArgs($api, ['/path', array('param1' => 'param1value'), array('option1' => 'option1value')]));
    }

    /**
     * @test
     */
    public function shouldPassPATCHRequestToClient()
    {
        $expectedArray = array('value');

        $httpClient = $this->getHttpMethodsMock(array('patch'));
        $httpClient
            ->expects($this->once())
            ->method('patch')
            ->with('/path', array('option1' => 'option1value'), json_encode(array('param1' => 'param1value')))
            ->will($this->returnValue($this->getPSR7Response($expectedArray)));

        $client = $this->getMockBuilder(\Github\Client::class)
            ->setMethods(array('getHttpClient'))
            ->getMock();
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $api = $this->getAbstractApiObject($client);
        $method = $this->getMethodReflection($api, 'patch');

        $this->assertEquals($expectedArray, $method->invokeArgs($api, ['/path', array('param1' => 'param1value'), array('option1' => 'option1value')]));
    }

    /**
     * @test
     */
    public function shouldPassPUTRequestToClient()
    {
        $expectedArray = array('value');

        $httpClient = $this->getHttpMethodsMock(array('put'));
        $httpClient
            ->expects($this->once())
            ->method('put')
            ->with('/path', array('option1' => 'option1value'), json_encode(array('param1' => 'param1value')))
            ->will($this->returnValue($this->getPSR7Response($expectedArray)));

        $client = $this->getMockBuilder('Github\Client')
            ->setMethods(array('getHttpClient'))
            ->getMock();
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $api = $this->getAbstractApiObject($client);
        $method = $this->getMethodReflection($api, 'put');

        $this->assertEquals($expectedArray, $method->invokeArgs($api, ['/path', array('param1' => 'param1value'), array('option1' => 'option1value')]));
    }

    /**
     * @test
     */
    public function shouldPassDELETERequestToClient()
    {
        $expectedArray = array('value');

        $httpClient = $this->getHttpMethodsMock(array('delete'));
        $httpClient
            ->expects($this->once())
            ->method('delete')
            ->with('/path', array('option1' => 'option1value'), json_encode(array('param1' => 'param1value')))
            ->will($this->returnValue($this->getPSR7Response($expectedArray)));

        $client = $this->getMockBuilder('Github\Client')
            ->setMethods(array('getHttpClient'))
            ->getMock();
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);


        $api = $this->getAbstractApiObject($client);
        $method = $this->getMethodReflection($api, 'delete');

        $this->assertEquals($expectedArray, $method->invokeArgs($api, ['/path', array('param1' => 'param1value'), array('option1' => 'option1value')]));
    }

    /**
     * @test
     */
    public function shouldNotPassEmptyRefToClient()
    {
        $expectedArray = array('value');

        $httpClient = $this->getHttpMethodsMock(array('get'));
        $httpClient
            ->expects($this->any())
            ->method('get')
            ->with('/path', array())
            ->will($this->returnValue($this->getPSR7Response($expectedArray)));

        $client = $this->getMockBuilder(\Github\Client::class)
            ->setMethods(array('getHttpClient'))
            ->getMock();
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $api = $this->getAbstractApiObject($client);
        $method = $this->getMethodReflection($api, 'get');

        $this->assertInternalType('array', $method->invokeArgs($api, ['/path', array('ref' => null)]));
    }

    /**
     * @param $client
     * @return AbstractApi
     */
    protected function getAbstractApiObject($client)
    {
        return $this->getMockBuilder(AbstractApi::class)
            ->setMethods(null)
            ->setConstructorArgs([$client])
            ->getMock();
    }

    /**
     * @param $api
     * @param $methodName
     * @return ReflectionMethod
     */
    protected function getMethodReflection($api, $methodName)
    {
        $method = new ReflectionMethod($api, $methodName);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * @return \Github\Client
     */
    protected function getClientMock()
    {
        return new \Github\Client($this->getHttpMethodsMock());
    }

    /**
     * Return a HttpMethods client mock
     *
     * @param array $methods
     * @return \Http\Client\Common\HttpMethodsClient
     */
    protected function getHttpMethodsMock(array $methods = array())
    {
        $methods = array_merge(array('sendRequest'), $methods);
        $mock = $this->getMockBuilder(\Http\Client\Common\HttpMethodsClient::class)
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMock();
        $mock
            ->expects($this->any())
            ->method('sendRequest');

        return $mock;
    }
    /**
     * @return \Http\Client\HttpClient
     */
    protected function getHttpClientMock()
    {
        $mock = $this->getMockBuilder(\Http\Client\HttpClient::class)
            ->setMethods(array('sendRequest'))
            ->getMock();
        $mock
            ->expects($this->any())
            ->method('sendRequest');

        return $mock;
    }

    /**
     * @param $expectedArray
     *
     * @return Response
     */
    private function getPSR7Response($expectedArray)
    {
        return new Response(
            200,
            array('Content-Type' => 'application/json'),
            \GuzzleHttp\Psr7\stream_for(json_encode($expectedArray))
        );
    }
}
