<?php

namespace Github\Tests\Api;

class GitDataTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetBlobsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\GitData\Blobs', $api->blobs());
    }

    /**
     * @test
     */
    public function shouldGetCommitsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\GitData\Commits', $api->commits());
    }

    /**
     * @test
     */
    public function shouldGetReferencesApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\GitData\References', $api->references());
    }

    /**
     * @test
     */
    public function shouldGetTagsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\GitData\Tags', $api->tags());
    }

    /**
     * @test
     */
    public function shouldGetTreesApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\GitData\Trees', $api->trees());
    }

    protected function getApiClass()
    {
        return 'Github\Api\GitData';
    }
}
