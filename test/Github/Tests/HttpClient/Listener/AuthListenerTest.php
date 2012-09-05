<?php

namespace Github\Tests\HttpClient;

use Github\Client;
use Github\Exception\InvalidArgumentException;
use Github\HttpClient\Listener\AuthListener;
use Github\HttpClient\Message\Request;

/**
 * HttpClient auth listener test case
 *
 * @author Leszek Prabucki <leszek.prabucki@gmail.com>
 */
class AuthListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldHaveLoginAndPasswordForAuthPassMethod()
    {
        $listener = new AuthListener(Client::AUTH_HTTP_PASSWORD, array('tokenOrLogin' => 'test'));
        $listener->preSend($this->getMock('Buzz\Message\RequestInterface'));
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldHaveTokenForHttpTokenMethod()
    {
        $listener = new AuthListener(Client::AUTH_HTTP_TOKEN, array('password' => 'pass'));
        $listener->preSend($this->getMock('Buzz\Message\RequestInterface'));
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldHaveTokenForUrlTokenMethod()
    {
        $listener = new AuthListener(Client::AUTH_URL_TOKEN, array('password' => 'login'));
        $listener->preSend($this->getMock('Buzz\Message\RequestInterface'));
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldHaveClientIdAndSecretForUrlClientIdMethod()
    {
        $listener = new AuthListener(Client::AUTH_URL_CLIENT_ID, array('password' => 'login'));
        $listener->preSend($this->getMock('Buzz\Message\RequestInterface'));
    }

    /**
     * @test
     */
    public function shouldDoNothingForHaveNullMethod()
    {
        $request = $this->getMock('Buzz\Message\RequestInterface');
        $request->expects($this->never())
            ->method('addHeader');
        $request->expects($this->never())
            ->method('fromUrl');
        $request->expects($this->never())
            ->method('getUrl');

        $listener = new AuthListener(null, array('password' => 'pass', 'tokenOrLogin' => 'test'));
        $this->assertNull($listener->preSend($request));
    }

    /**
     * @test
     */
    public function shouldDoNothingForPostSend()
    {
        $request = $this->getMock('Buzz\Message\RequestInterface');
        $request->expects($this->never())
            ->method('addHeader');
        $request->expects($this->never())
            ->method('fromUrl');
        $request->expects($this->never())
            ->method('getUrl');

        $response = $this->getMock('Buzz\Message\MessageInterface');
        $response->expects($this->never())
            ->method('addHeader');
        $response->expects($this->never())
            ->method('setContent');
        $response->expects($this->never())
            ->method('setHeaders');
        $response->expects($this->never())
            ->method('getContent');
        $response->expects($this->never())
            ->method('__toString');
        $response->expects($this->never())
            ->method('getHeader');

        $listener = new AuthListener(Client::AUTH_HTTP_PASSWORD, array('tokenOrLogin' => 'login', 'password' => 'mypasswd'));
        $this->assertNull($listener->postSend($request, $response));
    }

    /**
     * @test
     */
    public function shouldSetAuthBasicHeaderForAuthPassMethod()
    {
        $request = $this->getMock('Buzz\Message\RequestInterface');
        $request->expects($this->once())
            ->method('addHeader')
            ->with('Authorization: Basic '.base64_encode('login:mypasswd'));

        $listener = new AuthListener(Client::AUTH_HTTP_PASSWORD, array('tokenOrLogin' => 'login', 'password' => 'mypasswd'));
        $listener->preSend($request);
    }

    /**
     * @test
     */
    public function shouldSetAuthTokenHeaderForAuthPassMethod()
    {
        $request = $this->getMock('Buzz\Message\RequestInterface');
        $request->expects($this->once())
            ->method('addHeader')
            ->with('Authorization: token test');

        $listener = new AuthListener(Client::AUTH_HTTP_TOKEN, array('tokenOrLogin' => 'test'));
        $listener->preSend($request);
    }

    /**
     * @test
     */
    public function shouldSetTokenInUrlForAuthUrlMethod()
    {
        $request = new Request(Request::METHOD_GET, '/res');

        $listener = new AuthListener(Client::AUTH_URL_TOKEN, array('tokenOrLogin' => 'test'));
        $listener->preSend($request);

        $this->assertEquals('/res?access_token=test', $request->getUrl());
    }
}
