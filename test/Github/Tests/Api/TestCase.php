<?php

namespace Github\Tests\Api;

use Github\Client;
use Psr\Http\Client\ClientInterface;
use ReflectionMethod;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @return string
     */
    abstract protected function getApiClass();

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function getApiMock()
    {
        $httpClient = $this->getMockBuilder(ClientInterface::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $httpClient
            ->expects($this->any())
            ->method('sendRequest');

        $client = Client::createWithHttpClient($httpClient);

        return $this->getMockBuilder($this->getApiClass())
            ->setMethods(['get', 'post', 'postRaw', 'patch', 'delete', 'put', 'head'])
            ->setConstructorArgs([$client])
            ->getMock();
    }

    /**
     * @param object $object
     * @param string $methodName
     *
     * @return ReflectionMethod
     */
    protected function getMethod($object, $methodName)
    {
        $method = new ReflectionMethod($object, $methodName);
        $method->setAccessible(true);

        return $method;
    }
}
