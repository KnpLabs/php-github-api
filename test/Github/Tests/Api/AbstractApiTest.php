<?php declare(strict_types=1);

namespace Github\Tests\Api;

use Github\Api\AbstractApi;
use GuzzleHttp\Psr7\Response;

class AbstractApiTest extends TestCase
{
    public function shouldPassGETRequestToClient()
    {
        $expectedArray = ['value'];

        $httpClient = $this->getHttpMethodsMock(['get']);
        $httpClient
            ->expects($this->any())
            ->method('get')
            ->with('/path?param1=param1value', ['header1' => 'header1value'])
            ->will($this->returnValue($this->getPSR7Response($expectedArray)));
        $client = $this->getMockBuilder(\Github\Client::class)
            ->setMethods(['getHttpClient'])
            ->getMock();
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $api = $this->getAbstractApiObject($client);

        $actual = $this->getMethod($api, 'get')
            ->invokeArgs($api, ['/path', ['param1' => 'param1value'], ['header1' => 'header1value']]);

        $this->assertEquals($expectedArray, $actual);
    }

    public function shouldPassPOSTRequestToClient()
    {
        $expectedArray = ['value'];

        $httpClient = $this->getHttpMethodsMock(['post']);
        $httpClient
            ->expects($this->once())
            ->method('post')
            ->with('/path', ['option1' => 'option1value'], json_encode(['param1' => 'param1value']))
            ->will($this->returnValue($this->getPSR7Response($expectedArray)));

        $client = $this->getMockBuilder(\Github\Client::class)
            ->setMethods(['getHttpClient'])
            ->getMock();
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $api = $this->getAbstractApiObject($client);
        $actual = $this->getMethod($api, 'post')
            ->invokeArgs($api, ['/path', ['param1' => 'param1value'], ['option1' => 'option1value']]);

        $this->assertEquals($expectedArray, $actual);
    }

    public function shouldPassPATCHRequestToClient()
    {
        $expectedArray = ['value'];

        $httpClient = $this->getHttpMethodsMock(['patch']);
        $httpClient
            ->expects($this->once())
            ->method('patch')
            ->with('/path', ['option1' => 'option1value'], json_encode(['param1' => 'param1value']))
            ->will($this->returnValue($this->getPSR7Response($expectedArray)));

        $client = $this->getMockBuilder(\Github\Client::class)
            ->setMethods(['getHttpClient'])
            ->getMock();
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $api = $this->getAbstractApiObject($client);
        $actual = $this->getMethod($api, 'patch')
            ->invokeArgs($api, ['/path', ['param1' => 'param1value'], ['option1' => 'option1value']]);

        $this->assertEquals($expectedArray, $actual);
    }

    public function shouldPassPUTRequestToClient()
    {
        $expectedArray = ['value'];

        $httpClient = $this->getHttpMethodsMock(['put']);
        $httpClient
            ->expects($this->once())
            ->method('put')
            ->with('/path', ['option1' => 'option1value'], json_encode(['param1' => 'param1value']))
            ->will($this->returnValue($this->getPSR7Response($expectedArray)));

        $client = $this->getMockBuilder('Github\Client')
            ->setMethods(['getHttpClient'])
            ->getMock();
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $api = $this->getAbstractApiObject($client);
        $actual = $this->getMethod($api, 'put')
            ->invokeArgs($api, ['/path', ['param1' => 'param1value'], ['option1' => 'option1value']]);

        $this->assertEquals($expectedArray, $actual);
    }

    public function shouldPassDELETERequestToClient()
    {
        $expectedArray = ['value'];

        $httpClient = $this->getHttpMethodsMock(['delete']);
        $httpClient
            ->expects($this->once())
            ->method('delete')
            ->with('/path', ['option1' => 'option1value'], json_encode(['param1' => 'param1value']))
            ->will($this->returnValue($this->getPSR7Response($expectedArray)));

        $client = $this->getMockBuilder('Github\Client')
            ->setMethods(['getHttpClient'])
            ->getMock();
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);


        $api = $this->getAbstractApiObject($client);
        $actual = $this->getMethod($api, 'delete')
            ->invokeArgs($api, ['/path', ['param1' => 'param1value'], ['option1' => 'option1value']]);

        $this->assertEquals($expectedArray, $actual);
    }

    public function shouldNotPassEmptyRefToClient()
    {
        $expectedArray = ['value'];

        $httpClient = $this->getHttpMethodsMock(['get']);
        $httpClient
            ->expects($this->any())
            ->method('get')
            ->with('/path', [])
            ->will($this->returnValue($this->getPSR7Response($expectedArray)));

        $client = $this->getMockBuilder(\Github\Client::class)
            ->setMethods(['getHttpClient'])
            ->getMock();
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $api = $this->getAbstractApiObject($client);
        $actual = $this->getMethod($api, 'get')->invokeArgs($api, ['/path', ['ref' => null]]);

        $this->assertInternalType('array', $actual);
    }

    /**
     * @param $client
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getAbstractApiObject($client): \PHPUnit_Framework_MockObject_MockObject
    {
        return $this->getMockBuilder($this->getApiClass())
            ->setMethods(null)
            ->setConstructorArgs([$client])
            ->getMock();
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return AbstractApi::class;
    }

    /**
     * @return \Github\Client
     */
    protected function getClientMock(): \Github\Client
    {
        return new \Github\Client($this->getHttpMethodsMock());
    }

    /**
     * Return a HttpMethods client mock
     *
     * @param array $methods
     * @return \Http\Client\Common\HttpMethodsClient
     */
    protected function getHttpMethodsMock(array $methods = []): \Http\Client\Common\HttpMethodsClient
    {
        $methods = array_merge(['sendRequest'], $methods);
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
    protected function getHttpClientMock(): \Http\Client\HttpClient
    {
        $mock = $this->getMockBuilder(\Http\Client\HttpClient::class)
            ->setMethods(['sendRequest'])
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
    private function getPSR7Response($expectedArray): Response
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            \GuzzleHttp\Psr7\stream_for(json_encode($expectedArray))
        );
    }
}
