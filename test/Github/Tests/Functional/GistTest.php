<?php

namespace Github\Tests\Functional;

use Github\Client;

class GistTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldRetrievePublicGistsListWhenCalledAnonymously()
    {
        $github = new Client();
        $gists = $github->api('gists')->all();
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
    public function shouldNotGetStarredListWithoutAuthorization()
    {
        $github = new Client();
        $response = $github->api('gists')->all('starred');

        $this->assertEquals('Requires authentication', $response['message']);
    }

    /**
     * @test
     */
    public function shouldRetrievePublicGistsList()
    {
        $github = new Client();
        $gists = $github->api('gists')->all('public');
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

        $github = new Client();
        $gist = $github->api('gists')->show($id);

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
