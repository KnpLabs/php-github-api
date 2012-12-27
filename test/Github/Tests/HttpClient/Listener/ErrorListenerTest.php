<?php

namespace Github\Tests\HttpClient;

use Github\HttpClient\Listener\ErrorListener;

class ErrorListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldPassIfResponseNotHaveErrorStatus()
    {
        $response = $this->getMock('Github\HttpClient\Message\Response');
        $response->expects($this->once())
            ->method('isClientError')
            ->will($this->returnValue(false));

        $listener = new ErrorListener(array('api_limit' => 5000));
        $listener->postSend($this->getMock('Buzz\Message\RequestInterface'), $response);
    }

    /**
     * @test
     * @expectedException \Github\Exception\ApiLimitExceedException
     */
    public function shouldFailWhenApiLimitWasExceed()
    {
        $response = $this->getMock('Github\HttpClient\Message\Response');
        $response->expects($this->once())
            ->method('isClientError')
            ->will($this->returnValue(true));
        $response->expects($this->once())
            ->method('getHeader')
            ->with('X-RateLimit-Remaining')
            ->will($this->returnValue(0));

        $listener = new ErrorListener(array('api_limit' => 5000));
        $listener->postSend($this->getMock('Buzz\Message\RequestInterface'), $response);
    }

    /**
     * @test
     * @expectedException \Github\Exception\RuntimeException
     */
    public function shouldNotPassWhenContentWasNotValidJson()
    {
        $response = $this->getMock('Github\HttpClient\Message\Response');
        $response->expects($this->once())
            ->method('isClientError')
            ->will($this->returnValue(true));
        $response->expects($this->once())
            ->method('getHeader')
            ->with('X-RateLimit-Remaining')
            ->will($this->returnValue(5000));
        $response->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue('fail'));

        $listener = new ErrorListener(array('api_limit' => 5000));
        $listener->postSend($this->getMock('Buzz\Message\RequestInterface'), $response);
    }

    /**
     * @test
     * @expectedException \Github\Exception\RuntimeException
     */
    public function shouldNotPassWhenContentWasValidJsonButStatusIsNotCovered()
    {
        $response = $this->getMock('Github\HttpClient\Message\Response');
        $response->expects($this->once())
            ->method('isClientError')
            ->will($this->returnValue(true));
        $response->expects($this->once())
            ->method('getHeader')
            ->with('X-RateLimit-Remaining')
            ->will($this->returnValue(5000));
        $response->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue(array('message' => 'test')));
        $response->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue(404));

        $listener = new ErrorListener(array('api_limit' => 5000));
        $listener->postSend($this->getMock('Buzz\Message\RequestInterface'), $response);
    }

    /**
     * @test
     * @expectedException \Github\Exception\ErrorException
     */
    public function shouldNotPassWhen400IsSent()
    {
        $response = $this->getMock('Github\HttpClient\Message\Response');
        $response->expects($this->once())
            ->method('isClientError')
            ->will($this->returnValue(true));
        $response->expects($this->once())
            ->method('getHeader')
            ->with('X-RateLimit-Remaining')
            ->will($this->returnValue(5000));
        $response->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue(array('message' => 'test')));
        $response->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue(400));

        $listener = new ErrorListener(array('api_limit' => 5000));
        $listener->postSend($this->getMock('Buzz\Message\RequestInterface'), $response);
    }

    /**
     * @test
     * @dataProvider getErrorCodesProvider
     * @expectedException \Github\Exception\ValidationFailedException
     */
    public function shouldNotPassWhen422IsSentWithErrorCode($errorCode)
    {
        $content = array(
            'message' => 'Validation Failed',
            'errors'  => array(
                array(
                    'code'     => $errorCode,
                    'field'    => 'test',
                    'resource' => 'fake'
                )
            )
        );

        $response = $this->getMock('Github\HttpClient\Message\Response');
        $response->expects($this->once())
            ->method('isClientError')
            ->will($this->returnValue(true));
        $response->expects($this->once())
            ->method('getHeader')
            ->with('X-RateLimit-Remaining')
            ->will($this->returnValue(5000));
        $response->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue($content));
        $response->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue(422));

        $listener = new ErrorListener(array('api_limit' => 5000));
        $listener->postSend($this->getMock('Buzz\Message\RequestInterface'), $response);
    }

    public function getErrorCodesProvider()
    {
        return array(
            array('missing'),
            array('missing_field'),
            array('invalid'),
            array('already_exists'),
        );
    }
}
