<?php declare(strict_types=1);

namespace Github\Tests\Api;

class GitDataTest extends TestCase
{
    public function shouldGetBlobsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\GitData\Blobs::class, $api->blobs());
    }

    public function shouldGetCommitsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\GitData\Commits::class, $api->commits());
    }

    public function shouldGetReferencesApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\GitData\References::class, $api->references());
    }

    public function shouldGetTagsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\GitData\Tags::class, $api->tags());
    }

    public function shouldGetTreesApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\GitData\Trees::class, $api->trees());
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\GitData::class;
    }
}
