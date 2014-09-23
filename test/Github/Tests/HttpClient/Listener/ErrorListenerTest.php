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
        $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->once())
            ->method('isClientError')
            ->will($this->returnValue(false));

        $listener = new ErrorListener(array('api_limit' => 5000));
        $listener->onRequestError($this->getEventMock($response));
    }

    /**
     * @test
     * @expectedException \Github\Exception\ApiLimitExceedException
     */
    public function shouldFailWhenApiLimitWasExceed()
    {
        $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->once())
            ->method('isClientError')
            ->will($this->returnValue(true));
        $response->expects($this->once())
            ->method('getHeader')
            ->with('X-RateLimit-Remaining')
            ->will($this->returnValue(0));

        $listener = new ErrorListener(array('api_limit' => 5000));
        $listener->onRequestError($this->getEventMock($response));
    }

    /**
     * @test
     * @expectedException \Github\Exception\RuntimeException
     */
    public function shouldNotPassWhenContentWasNotValidJson()
    {
        $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->once())
            ->method('isClientError')
            ->will($this->returnValue(true));
        $response->expects($this->once())
            ->method('getHeader')
            ->with('X-RateLimit-Remaining')
            ->will($this->returnValue(5000));
        $response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue('fail'));

        $listener = new ErrorListener(array('api_limit' => 5000));
        $listener->onRequestError($this->getEventMock($response));
    }

    /**
     * @test
     * @expectedException \Github\Exception\RuntimeException
     */
    public function shouldNotPassWhenContentWasValidJsonButStatusIsNotCovered()
    {
        $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->once())
            ->method('isClientError')
            ->will($this->returnValue(true));
        $response->expects($this->once())
            ->method('getHeader')
            ->with('X-RateLimit-Remaining')
            ->will($this->returnValue(5000));
        $response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue(json_encode(array('message' => 'test'))));
        $response->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue(404));

        $listener = new ErrorListener(array('api_limit' => 5000));
        $listener->onRequestError($this->getEventMock($response));
    }

    /**
     * @test
     * @expectedException \Github\Exception\ErrorException
     */
    public function shouldNotPassWhen400IsSent()
    {
        $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->once())
            ->method('isClientError')
            ->will($this->returnValue(true));
        $response->expects($this->once())
            ->method('getHeader')
            ->with('X-RateLimit-Remaining')
            ->will($this->returnValue(5000));
        $response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue(json_encode(array('message' => 'test'))));
        $response->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue(400));

        $listener = new ErrorListener(array('api_limit' => 5000));
        $listener->onRequestError($this->getEventMock($response));
    }

    /**
     * @test
     * @dataProvider getErrorCodesProvider
     * @expectedException \Github\Exception\ValidationFailedException
     */
    public function shouldNotPassWhen422IsSentWithErrorCode($errorCode)
    {
        $content = json_encode(array(
            'message' => 'Validation Failed',
            'errors'  => array(
                array(
                    'code'     => $errorCode,
                    'field'    => 'test',
                    'value'    => 'wrong',
                    'resource' => 'fake'
                )
            )
        ));

        $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->once())
            ->method('isClientError')
            ->will($this->returnValue(true));
        $response->expects($this->once())
            ->method('getHeader')
            ->with('X-RateLimit-Remaining')
            ->will($this->returnValue(5000));
        $response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($content));
        $response->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue(422));

        $listener = new ErrorListener(array('api_limit' => 5000));
        $listener->onRequestError($this->getEventMock($response));
    }

    /**
     * @test
     * @expectedException \Github\Exception\TwoFactorAuthenticationRequiredException
     */
    public function shouldThrowTwoFactorAuthenticationRequiredException()
    {
        $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->once())
            ->method('isClientError')
            ->will($this->returnValue(true));
        $response->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue(401));
        $response->expects($this->any())
            ->method('getHeader')
            ->will($this->returnCallback(function ($name) {
                switch ($name) {
                    case 'X-RateLimit-Remaining':
                        return 5000;
                    case 'X-GitHub-OTP':
                        return 'required; sms';
                }
            }));
        $response->expects($this->any())
            ->method('hasHeader')
            ->with('X-GitHub-OTP')
            ->will($this->returnValue(true));

        $listener = new ErrorListener(array());
        $listener->onRequestError($this->getEventMock($response));
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

    private function getEventMock($response)
    {
        $mock = $this->getMockBuilder('Guzzle\Common\Event')->getMock();

        $request = $this->getMockBuilder('Guzzle\Http\Message\Request')->disableOriginalConstructor()->getMock();

        $request->expects($this->any())
            ->method('getResponse')
            ->will($this->returnValue($response));

        $mock->expects($this->any())
            ->method('offsetGet')
            ->will($this->returnValue($request));

        return $mock;
    }
}
