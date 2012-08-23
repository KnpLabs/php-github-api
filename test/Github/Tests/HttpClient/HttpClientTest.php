<?php

namespace Github\Tests\HttpClient;

use Github\HttpClient\HttpClient;
use Buzz\Message\Response;

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
        ));

        $this->assertEquals(33, $httpClient->getOption('timeout'));
        $this->assertEquals(443, $httpClient->getOption('http_port'));
    }

    /**
     * @test
     */
    public function shouldBeAbleToSetOption()
    {
        $httpClient = new TestHttpClient(array());
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
        $options    = array('c' => 'd');

        $browser = $this->getBrowserMock();
        $browser
            ->expects($this->once())
            ->method('call')
            ->with('https://api.github.com/some/path?a=b', 'GET', array(), '[]')
            ->will($this->returnValue($this->getMock('Buzz\Message\MessageInterface')));

        $httpClient = new HttpClient(array(), $browser);
        $httpClient->get($path, $parameters, $options);
    }

    /**
     * @test
     */
    public function shouldDoPOSTRequest()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $options    = array('c' => 'd');

        $browser = $this->getBrowserMock();
        $browser
            ->expects($this->once())
            ->method('call')
            ->with('https://api.github.com/some/path', 'POST', array(), json_encode($parameters))
            ->will($this->returnValue($this->getMock('Buzz\Message\MessageInterface')));

        $httpClient = new HttpClient(array(), $browser);
        $httpClient->post($path, $parameters, $options);
    }

    /**
     * @test
     */
    public function shouldDoPATCHRequest()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $options    = array('c' => 'd');

        $browser = $this->getBrowserMock();
        $browser
            ->expects($this->once())
            ->method('call')
            ->with('https://api.github.com/some/path', 'PATCH', array(), json_encode($parameters))
            ->will($this->returnValue($this->getMock('Buzz\Message\MessageInterface')));

        $httpClient = new HttpClient(array(), $browser);
        $httpClient->patch($path, $parameters, $options);
    }

    /**
     * @test
     */
    public function shouldDoDELETERequest()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $options    = array('c' => 'd');

        $browser = $this->getBrowserMock();
        $browser
            ->expects($this->once())
            ->method('call')
            ->with('https://api.github.com/some/path', 'DELETE', array(), json_encode($parameters))
            ->will($this->returnValue($this->getMock('Buzz\Message\MessageInterface')));

        $httpClient = new HttpClient(array(), $browser);
        $httpClient->delete($path, $parameters, $options);
    }

    /**
     * @test
     */
    public function shouldDoPUTRequest()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $options    = array('c' => 'd');

        $browser = $this->getBrowserMock();
        $browser
            ->expects($this->once())
            ->method('call')
            ->with('https://api.github.com/some/path', 'PUT', array(), '[]')
            ->will($this->returnValue($this->getMock('Buzz\Message\MessageInterface')));

        $httpClient = new HttpClient(array(), $browser);
        $httpClient->put($path, $options);
    }

    /**
     * @test
     */
    public function shouldDoCustomRequest()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $options    = array('c' => 'd');

        $browser = $this->getBrowserMock();
        $browser
            ->expects($this->once())
            ->method('call')
            ->with('https://api.github.com/some/path', 'HEAD', array(), json_encode($parameters))
            ->will($this->returnValue($this->getMock('Buzz\Message\MessageInterface')));

        $httpClient = new HttpClient(array(), $browser);
        $httpClient->request($path, $parameters, 'HEAD', $options);
    }

    /**
     * @test
     */
    public function shouldHandlePagination()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $options    = array('c' => 'd');

        $response = new Response();
        $response->addHeader("Link:<page1>; rel=\"page2\"\n<page3>; rel=\"page4\"");

        $browser = $this->getBrowserMock();
        $browser
            ->expects($this->once())
            ->method('call')
            ->with('https://api.github.com/some/path', 'HEAD', array(), json_encode($parameters))
            ->will($this->returnValue($response));

        $httpClient = new HttpClient(array(), $browser);
        $httpClient->request($path, $parameters, 'HEAD', $options);

        $this->assertEquals(array('page2' => 'page1', 'page4' => 'page3'), $httpClient->getPagination());
    }

    /**
     * @test
     */
    public function shouldGetEmtpyPaginationWhenNotDoRequest()
    {
        $httpClient = new HttpClient(array());

        $this->assertNull($httpClient->getPagination());
    }

    /**
     * @test
     */
    public function shouldAllowToReturnRawContent()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $options    = array('c' => 'd');

        $message = $this->getMock('Buzz\Message\MessageInterface');
        $message->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue("Just raw context"));

        $browser = $this->getBrowserMock();
        $browser
            ->expects($this->once())
            ->method('call')
            ->will($this->returnValue($message));

        $httpClient = new HttpClient(array(), $browser);
        $content = $httpClient->get($path, $parameters, $options);

        $this->assertEquals("Just raw context", $content);
    }

    /**
     * @test
     * @expectedException Github\Exception\ApiLimitExceedException
     */
    public function shouldThrowExceptionWhenApiIsExceeded()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $options    = array('c' => 'd');

        $response = new Response();
        $response->addHeader("X-RateLimit-Remaining: 0");

        $browser = $this->getBrowserMock();
        $browser
            ->expects($this->once())
            ->method('call')
            ->will($this->returnValue($response));

        $httpClient = new HttpClient(array(), $browser);
        $content = $httpClient->get($path, $parameters, $options);
    }

    /**
     * @test
     */
    public function shouldAuthenticateUsingListener()
    {
        $browser = $this->getBrowserMock();
        $browser
            ->expects($this->once())
            ->method('addListener')
            ->with($this->isInstanceOf('Github\HttpClient\Listener\AuthListener'));

        $httpClient = new HttpClient(array(), $browser);
        $content = $httpClient->authenticate();
    }

    protected function getBrowserMock()
    {
        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($this->getMock('Buzz\Client\AbstractClient')));

        return $browser;
    }
}

class TestHttpClient extends HttpClient
{
    public function getOption($name, $default = null)
    {
        return isset($this->options[$name]) ? $this->options[$name] : $default;
    }
}
