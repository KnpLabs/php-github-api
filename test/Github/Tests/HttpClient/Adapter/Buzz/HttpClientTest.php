<?php

namespace Github\Tests\HttpClient\Adapter\Buzz;

use Github\Client;
use Github\HttpClient\Adapter\Buzz\Listener\AuthListener;
use Github\HttpClient\Adapter\Buzz\HttpClient;
use Github\HttpClient\Adapter\Buzz\Message\Request;
use Github\HttpClient\Adapter\Buzz\Message\Response;

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

        $message = $this->getMock('Github\HttpClient\Adapter\Buzz\Message\Response');
        $message->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue('Just raw context'));

        $client = $this->getBrowserMock();

        $httpClient = new TestHttpClient(array(), $client);
        $httpClient->fakeResponse = $message;

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
        $httpClient->fakeResponse = $response;

        $httpClient->get($path, $parameters, $headers);
    }

    /**
     * @test
     * @dataProvider getAuthenticationFullData
     */
    public function shouldAuthenticateUsingAllGivenParameters($login, $password, $method)
    {
        $httpClient = new HttpClient();

        $n = count($httpClient->getListeners());

        $httpClient->authenticate($method, $login, $password);

        $listeners = $httpClient->getListeners();
        $this->assertCount($n + 1, $listeners);

        $listener = array_pop($listeners);
        $this->assertEquals($method, $listener->getMethod());
        $this->assertEquals(array('tokenOrLogin' => $login, 'password' => $password), $listener->getOptions());
    }

    public function getAuthenticationFullData()
    {
        return array(
            array('login', 'password', Client::AUTH_HTTP_PASSWORD),
            array('token', null, Client::AUTH_HTTP_TOKEN),
            array('token', null, Client::AUTH_URL_TOKEN),
            array('client_id', 'client_secret', Client::AUTH_URL_CLIENT_ID),
        );
    }

    /**
     * @test
     * @dataProvider getAuthenticationPartialData
     */
    public function shouldAuthenticateUsingGivenParameters($token, $method)
    {
        $httpClient = new HttpClient();

        $n = count($httpClient->getListeners());

        $httpClient->authenticate($method, $token);

        $listeners = $httpClient->getListeners();
        $this->assertCount($n + 1, $listeners);

        $listener = array_pop($listeners);
        $this->assertEquals($method, $listener->getMethod());
        $this->assertEquals(array('tokenOrLogin' => $token, 'password' => null), $listener->getOptions());
    }

    public function getAuthenticationPartialData()
    {
        return array(
            array('token', Client::AUTH_HTTP_TOKEN),
            array('token', Client::AUTH_URL_TOKEN),
        );
    }

    protected function getBrowserMock()
    {
        return $this->getMock('Buzz\Client\ClientInterface', array('setTimeout', 'setVerifyPeer', 'send'));
    }
}

class TestHttpClient extends HttpClient
{
    public $fakeResponse;

    public function getOption($name, $default = null)
    {
        return isset($this->options[$name]) ? $this->options[$name] : $default;
    }

    public function clearHeaders()
    {
    }

    public function request($path, array $parameters = array(), $httpMethod = 'GET', array $headers = array())
    {
        $request  = $this->createRequest($httpMethod, $path);
        $response = $this->createResponse();
        if (0 < count($this->listeners)) {
            foreach ($this->listeners as $listener) {
                $listener->postSend($request, $response);
            }
        }

        return $response;
    }

    protected function createRequest($httpMethod, $url)
    {
        return new Request($httpMethod);
    }

    protected function createResponse()
    {
        return $this->fakeResponse ?: new Response();
    }
}
