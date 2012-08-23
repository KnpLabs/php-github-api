<?php

namespace Github\Tests\Api;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    abstract protected function getApiClass();

    protected function getApiMock()
    {
        $client = $this->getMockBuilder('Github\Client')
            ->disableOriginalConstructor()
            ->getMock();

        return $this->getMockBuilder($this->getApiClass())
            ->setMethods(array('get', 'post', 'patch', 'delete', 'put'))
            ->setConstructorArgs(array($client))
            ->getMock();
    }
}
