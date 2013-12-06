<?php

namespace Github\Tests\HttpClient\Cache;

use Guzzle\Http\Message\Response;
use Github\HttpClient\Cache\GaufretteCache;

class GaufretteCacheTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!class_exists('Gaufrette\Filesystem')) {
            $this->markTestSkipped('Gaufrette not installed.');
        }
    }

    /**
     * @test
     */
    public function shouldStoreAResponseForAGivenKey()
    {
        $response = new Response(200);
        $filesystem = $this->getMockBuilder('Gaufrette\Filesystem')->disableOriginalConstructor()->getMock();
        $filesystem
            ->expects($this->once())
            ->method('write')
            ->with('test', serialize($response))
        ;
        $filesystem
            ->expects($this->once())
            ->method('read')
            ->with('test')
            ->will($this->returnValue('a:0:{}'))
        ;

        $cache = new GaufretteCache($filesystem);
        $cache->set('test', $response);
        $this->assertNotNull($cache->get('test'));
    }

    /**
     * @test
     */
    public function shouldGetATimestampForExistingFile()
    {
        $response = new Response(200);
        $filesystem = $this->getMockBuilder('Gaufrette\Filesystem')->disableOriginalConstructor()->getMock();
        $filesystem
            ->expects($this->once())
            ->method('has')
            ->with('test')
            ->will($this->returnValue(true))
        ;
        $filesystem
            ->expects($this->once())
            ->method('mtime')
            ->with('test')
            ->will($this->returnValue(100))
        ;

        $cache = new GaufretteCache($filesystem);
        $cache->set('test', new Response(200));

        $this->assertInternalType('int', $cache->getModifiedSince('test'));
    }

    /**
     * @test
     */
    public function shouldNotGetATimestampForInexistingFile()
    {
        $filesystem = $this->getMockBuilder('Gaufrette\Filesystem')->disableOriginalConstructor()->getMock();
        $filesystem
            ->expects($this->once())
            ->method('has')
            ->with('test2')
            ->will($this->returnValue(false))
        ;

        $cache = new GaufretteCache($filesystem);

        $this->assertNull($cache->getModifiedSince('test2'));
    }
}
