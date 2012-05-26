<?php

namespace Github\Tests;

abstract class ApiTestCase extends \PHPUnit_Framework_TestCase
{
    abstract protected function getApiClass();

    protected function getApiMock()
    {
        return $this->getMockBuilder($this->getApiClass())
            ->setMethods(array('get', 'post', 'patch', 'delete'))
            ->disableOriginalConstructor()
            ->getMock();
    }
}
