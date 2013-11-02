<?php

namespace Github\Tests\HttpClient;

use Guzzle\Http\Message\Request;

use Github\Client;
use Github\HttpClient\Listener\AuthListener;

class AuthListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function shouldHaveKnownMethodName()
    {
        $listener = new AuthListener('test', null, 'unknown');
        $listener->onRequestBeforeSend($this->getEventMock());
    }

    /**
     * @test
     */
    public function shouldDoNothingForHaveNullMethod()
    {
        $request = $this->getMock('Guzzle\Http\Message\RequestInterface');
        $request->expects($this->never())
            ->method('addHeader');
        $request->expects($this->never())
            ->method('fromUrl');
        $request->expects($this->never())
            ->method('getUrl');

        $listener = new AuthListener('test', 'pass', null);
        $listener->onRequestBeforeSend($this->getEventMock($request));
    }

    /**
     * @test
     */
    public function shouldDoNothingForPostSend()
    {
        $request = $this->getMock('Guzzle\Http\Message\RequestInterface');
        $request->expects($this->never())
            ->method('addHeader');
        $request->expects($this->never())
            ->method('fromUrl');
        $request->expects($this->never())
            ->method('getUrl');

        $listener = new AuthListener('login', 'somepassphrase', Client::AUTH_HTTP_PASSWORD);
        $listener->onRequestBeforeSend($this->getEventMock($request));
    }

    /**
     * @test
     */
    public function shouldSetAuthBasicHeaderForAuthPassMethod()
    {
        $expected = 'Basic '.base64_encode('login2:pass42323');

        $request = $this->getMock('Guzzle\Http\Message\RequestInterface');
        $request->expects($this->once())
            ->method('setHeader')
            ->with('Authorization', $expected);
        $request->expects($this->once())
            ->method('getHeader')
            ->with('Authorization')
            ->will($this->returnValue($expected));

        $listener = new AuthListener('login2', 'pass42323', Client::AUTH_HTTP_PASSWORD);
        $listener->onRequestBeforeSend($this->getEventMock($request));

        $this->assertEquals($expected, $request->getHeader('Authorization'));
    }

    /**
     * @test
     */
    public function shouldSetAuthTokenHeaderForAuthPassMethod()
    {
        $expected = 'token test';

        $request = $this->getMock('Guzzle\Http\Message\RequestInterface');
        $request->expects($this->once())
            ->method('setHeader')
            ->with('Authorization', $expected);
        $request->expects($this->once())
            ->method('getHeader')
            ->with('Authorization')
            ->will($this->returnValue($expected));

        $listener = new AuthListener('test', null, Client::AUTH_HTTP_TOKEN);
        $listener->onRequestBeforeSend($this->getEventMock($request));

        $this->assertEquals($expected, $request->getHeader('Authorization'));
    }

    /**
     * @test
     */
    public function shouldSetTokenInUrlForAuthUrlMethod()
    {
        $request = new Request('GET', '/res');

        $listener = new AuthListener('test', null, Client::AUTH_URL_TOKEN);
        $listener->onRequestBeforeSend($this->getEventMock($request));

        $this->assertEquals('/res?access_token=test', $request->getUrl());
    }

    /**
     * @test
     */
    public function shouldSetClientDetailsInUrlForAuthUrlMethod()
    {
        $request = new Request('GET', '/res');

        $listener = new AuthListener('clientId', 'clientSecret', Client::AUTH_URL_CLIENT_ID);
        $listener->onRequestBeforeSend($this->getEventMock($request));

        $this->assertEquals('/res?client_id=clientId&client_secret=clientSecret', $request->getUrl());
    }

    private function getEventMock($request = null)
    {
        $mock = $this->getMockBuilder('Guzzle\Common\Event')->getMock();

        if ($request) {
            $mock->expects($this->any())
                ->method('offsetGet')
                ->will($this->returnValue($request));
        }

        return $mock;
    }
}
