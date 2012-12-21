<?php

namespace Github\Tests\HttpClient\Cache;

use Github\HttpClient\Message\Response;
use Github\HttpClient\Cache\FilesystemCache;

class FilesystemCacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldStoreAResponseForAGivenKey()
    {
        $cache = new FilesystemCache('/tmp/github-api-test');

        $cache->set('test', new Response);

        $this->assertNotNull($cache->get('test'));
    }

    /**
     * @test
     */
    public function shouldGetATimestampForExistingFile()
    {
        $cache = new FilesystemCache('/tmp/github-api-test');

        $cache->set('test', new Response);

        $this->assertInternalType('int', $cache->getModifiedSince('test'));
    }

    /**
     * @test
     */
    public function shouldNotGetATimestampForInexistingFile()
    {
        $cache = new FilesystemCache('/tmp/github-api-test');

        $this->assertNull($cache->getModifiedSince('test2'));
    }
}

