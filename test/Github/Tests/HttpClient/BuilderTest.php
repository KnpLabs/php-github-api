<?php

namespace Github\Tests\HttpClient;

use Http\Client\Common\Plugin;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class BuilderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function shouldClearHeaders()
    {
        $builder = $this->getMockBuilder(\Github\HttpClient\Builder::class)
            ->setMethods(['addPlugin', 'removePlugin'])
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
        $headers = ['header1', 'header2'];

        $client = $this->getMockBuilder(\Github\HttpClient\Builder::class)
            ->setMethods(['addPlugin', 'removePlugin'])
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

    /**
     * @test
     */
    public function appendingHeaderShouldAddAndRemovePlugin()
    {
        $expectedHeaders = [
            'Accept' => 'application/vnd.github.v3',
        ];

        $client = $this->getMockBuilder(\Github\HttpClient\Builder::class)
            ->setMethods(['removePlugin', 'addPlugin'])
            ->getMock();

        $client->expects($this->once())
            ->method('removePlugin')
            ->with(Plugin\HeaderAppendPlugin::class);

        $client->expects($this->once())
            ->method('addPlugin')
            ->with(new Plugin\HeaderAppendPlugin($expectedHeaders));

        $client->addHeaderValue('Accept', 'application/vnd.github.v3');
    }
}
