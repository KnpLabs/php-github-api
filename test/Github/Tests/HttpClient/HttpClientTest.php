<?php

namespace Github\Tests\HttpClient;

use Github\HttpClient\HttpClient;
use Github\HttpClient\Message\Request;
use Github\HttpClient\Message\Response;

/**
 * HttpClient test case
 *
 * @author Leszek Prabucki <leszek.prabucki@gmail.com>
 */
class HttpClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldBeAbleToPassOptionsToConstructor()
    {
        $httpClient = new TestHttpClient(array(
            'timeout' => 33
        ), $this->getBrowserMock());

        $this->assertEquals(33, $httpClient->getOption('timeout'));
        $this->assertEquals(5000, $httpClient->getOption('api_limit'));
    }

    /**
     * @test
     */
    public function shouldBeAbleToSetOption()
    {
        $httpClient = new TestHttpClient(array(), $this->getBrowserMock());
        $httpClient->setOption('timeout', 666);

        $this->assertEquals(666, $httpClient->getOption('timeout'));
    }

    /**
     * @test
     */
    public function shouldDoGETRequest()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $headers    = array('c' => 'd');

        $client = $this->getBrowserMock();

        $httpClient = new HttpClient(array(), $client);
        $httpClient->get($path, $parameters, $headers);
    }

    /**
     * @test
     */
    public function shouldDoPOSTRequest()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $headers    = array('c' => 'd');

        $client = $this->getBrowserMock();

        $httpClient = new HttpClient(array(), $client);
        $httpClient->post($path, $parameters, $headers);
    }

    /**
     * @test
     */
    public function shouldDoPATCHRequest()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $headers    = array('c' => 'd');

        $client = $this->getBrowserMock();

        $httpClient = new HttpClient(array(), $client);
        $httpClient->patch($path, $parameters, $headers);
    }

    /**
     * @test
     */
    public function shouldDoDELETERequest()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $headers    = array('c' => 'd');

        $client = $this->getBrowserMock();

        $httpClient = new HttpClient(array(), $client);
        $httpClient->delete($path, $parameters, $headers);
    }

    /**
     * @test
     */
    public function shouldDoPUTRequest()
    {
        $path       = '/some/path';
        $headers    = array('c' => 'd');

        $client = $this->getBrowserMock();

        $httpClient = new HttpClient(array(), $client);
        $httpClient->put($path, $headers);
    }

    /**
     * @test
     */
    public function shouldDoCustomRequest()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $options    = array('c' => 'd');

        $client = $this->getBrowserMock();

        $httpClient = new HttpClient(array(), $client);
        $httpClient->request($path, $parameters, 'HEAD', $options);
    }

    /**
     * @test
     */
    public function shouldHandlePagination()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $headers    = array('c' => 'd');

        $response = new Response();
        $response->addHeader("Link:<page1>; rel=\"page2\", \n<page3>; rel=\"page4\"");

        $client = $this->getBrowserMock();

        $httpClient = new HttpClient(array(), $client);
        $httpClient->request($path, $parameters, 'HEAD', $headers);

        $this->assertEquals(array('page2' => 'page1', 'page4' => 'page3'), $response->getPagination());
    }

    /**
     * @test
     */
    public function shouldAllowToReturnRawContent()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $headers    = array('c' => 'd');

        $message = $this->getMock('Github\HttpClient\Message\Response');
        $message->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue('Just raw context'));

        $client = $this->getBrowserMock();

        $httpClient = new TestHttpClient(array(), $client);
        $httpClient->setFakeResponse($message);

        $response = $httpClient->get($path, $parameters, $headers);

        $this->assertEquals("Just raw context", $response->getContent());
        $this->assertInstanceOf('Buzz\Message\MessageInterface', $response);
    }

    /**
     * @test
     * @expectedException \Github\Exception\ApiLimitExceedException
     */
    public function shouldThrowExceptionWhenApiIsExceeded()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $headers    = array('c' => 'd');

        $response = new Response();
        $response->addHeader('HTTP/1.1 403 Forbidden');
        $response->addHeader('X-RateLimit-Remaining: 0');

        $httpClient = new TestHttpClient(array(), $this->getBrowserMock());
        $httpClient->setFakeResponse($response);

        $httpClient->get($path, $parameters, $headers);
    }

    protected function getBrowserMock()
    {
        return $this->getMock('Buzz\Client\ClientInterface', array('setTimeout', 'setVerifyPeer', 'send'));
    }
}

class TestHttpClient extends HttpClient
{
    public $fakeResponse;

    public function setFakeResponse($response)
    {
        $this->fakeResponse = $response;
    }

    public function getOption($name, $default = null)
    {
        return isset($this->options[$name]) ? $this->options[$name] : $default;
    }

    public function clearHeaders()
    {
    }

    public function request($path, array $parameters = array(), $httpMethod = 'GET', array $headers = array(), Response $response = null)
    {
        $request  = new Request($httpMethod);
        $response = $this->fakeResponse ? $this->fakeResponse : new Response();
        if (0 < count($this->listeners)) {
            foreach ($this->listeners as $listener) {
                $listener->postSend($request, $response);
            }
        }

        return $response;
    }
}
