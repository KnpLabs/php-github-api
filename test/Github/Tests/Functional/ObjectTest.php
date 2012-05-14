<?php

namespace Github\Tests\Functional;

use Github\Client;

class ObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldGetRawData()
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';
        $sha      = 'dd2630b84b948e7ed9a58f9828abb8d6dea2b2a9';

        $github = new Client();
        $data = $github->getObjectApi()->getRawData($username, $repo, $sha);

        $this->assertRegexp('/Copyright/', $data);
    }

    /**
     * @test
     */
    public function shouldShowHeadTree()
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';
        $sha      = 'HEAD';

        $github = new Client();
        $tree = $github->getObjectApi()->showTree($username, $repo, $sha);

        $this->assertArrayHasKey('url', $tree);
        $this->assertArrayHasKey('sha', $tree);
        $this->assertArrayHasKey('tree', $tree);
    }

    /**
     * @test
     */
    public function shouldListBlobsFromTree()
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';
        $sha      = 'HEAD';

        $github = new Client();
        $blobs = $github->getObjectApi()->listBlobs($username, $repo, $sha);

        $blob = reset($blobs);

        $this->assertArrayHasKey('url', $blob);
        $this->assertEquals('blob', $blob['type']);
        $this->assertArrayHasKey('size', $blob);
        $this->assertArrayHasKey('path', $blob);
        $this->assertArrayHasKey('sha', $blob);
        $this->assertArrayHasKey('mode', $blob);
    }

    /**
     * @test
     */
    public function shouldShowBlob()
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';
        $sha      = 'a9300ff6c7da0b70913b9a39d59a416b0f6c0c5a';

        $github = new Client();
        $blob = $github->getObjectApi()->showBlob($username, $repo, $sha, 'CHANGELOG');

        $this->assertArrayHasKey('url', $blob);
        $this->assertEquals('blob', $blob['type']);
        $this->assertEquals('CHANGELOG', $blob['path']);
        $this->assertArrayHasKey('size', $blob);
        $this->assertArrayHasKey('sha', $blob);
        $this->assertArrayHasKey('mode', $blob);
    }
}
