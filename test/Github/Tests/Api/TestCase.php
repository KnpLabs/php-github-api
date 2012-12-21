<?php

namespace Github\Tests\Api;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    abstract protected function getApiClass();

    protected function getApiMock()
    {
        $httpClient = $this->getMock('Buzz\Client\ClientInterface', array('setTimeout', 'setVerifyPeer', 'send'));
        $httpClient
            ->expects($this->any())
            ->method('setTimeout')
            ->with(10);
        $httpClient
            ->expects($this->any())
            ->method('setVerifyPeer')
            ->with(false);
        $httpClient
            ->expects($this->any())
            ->method('send');

        $mock = $this->getMock('Github\HttpClient\HttpClient', array(), array(array(), $httpClient));

        $client = new \Github\Client($mock);
        $client->setHttpClient($mock);

        return $this->getMockBuilder($this->getApiClass())
            ->setMethods(array('get', 'post', 'patch', 'delete', 'put'))
            ->setConstructorArgs(array($client))
            ->getMock();
    }
}
