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

        $this->assertInstanceOf(\Github\Api\GitData\Blobs::class, $api->blobs());
    }

    /**
     * @test
     */
    public function shouldGetCommitsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\GitData\Commits::class, $api->commits());
    }

    /**
     * @test
     */
    public function shouldGetReferencesApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\GitData\References::class, $api->references());
    }

    /**
     * @test
     */
    public function shouldGetTagsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\GitData\Tags::class, $api->tags());
    }

    /**
     * @test
     */
    public function shouldGetTreesApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\GitData\Trees::class, $api->trees());
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\GitData::class;
    }
}
