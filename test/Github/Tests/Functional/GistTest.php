<?php

namespace Github\Tests\Functional;

/**
 * @group functional
 */
class GistTest extends TestCase
{
    /**
     * @test
     */
    public function shouldRetrievePublicGistsListWhenCalledAnonymously()
    {
        $gists = $this->client->api('gists')->all();
        $gist = array_pop($gists);

        $this->assertArrayHasKey('url', $gist);
        $this->assertArrayHasKey('files', $gist);
        $this->assertArrayHasKey('comments', $gist);
        $this->assertArrayHasKey('created_at', $gist);
        $this->assertArrayHasKey('updated_at', $gist);
        $this->assertArrayHasKey('user', $gist);
    }

    /**
     * @test
     * @expectedException \Github\Exception\RuntimeException
     */
    public function shouldNotGetStarredListWithoutAuthorization()
    {
        $this->client->api('gists')->all('starred');
    }

    /**
     * @test
     */
    public function shouldRetrievePublicGistsList()
    {
        $gists = $this->client->api('gists')->all('public');
        $gist = array_pop($gists);

        $this->assertArrayHasKey('url', $gist);
        $this->assertArrayHasKey('files', $gist);
        $this->assertArrayHasKey('comments', $gist);
        $this->assertArrayHasKey('created_at', $gist);
        $this->assertArrayHasKey('updated_at', $gist);
        $this->assertArrayHasKey('user', $gist);
    }

    /**
     * @test
     */
    public function shouldRetrieveGistById()
    {
        $id = 1;

        $gist = $this->client->api('gists')->show($id);

        $this->assertArrayHasKey('url', $gist);
        $this->assertArrayHasKey('files', $gist);
        $this->assertArrayHasKey('comments', $gist);
        $this->assertArrayHasKey('created_at', $gist);
        $this->assertArrayHasKey('updated_at', $gist);
        $this->assertArrayHasKey('user', $gist);
        $this->assertArrayHasKey('gistfile1.txt', $gist['files']);
        $this->assertEquals('schacon', $gist['user']['login']);
    }
}
