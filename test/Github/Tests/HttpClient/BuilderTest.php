<?php

namespace Github\Tests\HttpClient;

use Github\Api;
use Github\Client;
use Github\Exception\BadMethodCallException;
use Github\HttpClient\Plugin\Authentication;
use Http\Client\Common\Plugin;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldClearHeaders()
    {
        $builder = $this->getMockBuilder(\Github\HttpClient\Builder::class)
            ->setMethods(array('addPlugin', 'removePlugin'))
            ->getMock();
        $builder->expects($this->once())
            ->method('addPlugin')
            ->with($this->isInstanceOf(Plugin\HeaderAppendPlugin::class));

        $builder->expects($this->once())
            ->method('removePlugin')
            ->with(Plugin\HeaderAppendPlugin::class);

        $builder->clearHeaders();
    }



    /**
     * @test
     */
    public function shouldAddHeaders()
    {
        $headers = array('header1', 'header2');

        $client = $this->getMockBuilder(\Github\HttpClient\Builder::class)
            ->setMethods(array('addPlugin', 'removePlugin'))
            ->getMock();
        $client->expects($this->once())
            ->method('addPlugin')
            // TODO verify that headers exists
            ->with($this->isInstanceOf(Plugin\HeaderAppendPlugin::class));

        $client->expects($this->once())
            ->method('removePlugin')
            ->with(Plugin\HeaderAppendPlugin::class);

        $client->addHeaders($headers);
    }
}
