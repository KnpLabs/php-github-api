<?php

namespace Github\Tests\Api;

class GistsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetStarredGists()
    {
        $expectedArray = [['id' => '123']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gists/starred')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('starred'));
    }

    /**
     * @test
     */
    public function shouldGetAllGists()
    {
        $expectedArray = [['id' => '123']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gists')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all());
    }

    /**
     * @test
     */
    public function shouldShowGist()
    {
        $expectedArray = ['id' => '123'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gists/123')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show(123));
    }

    /**
     * @test
     */
    public function shouldShowCommits()
    {
        $expectedArray = ['id' => '123'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gists/123/commits')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->commits(123));
    }

    /**
     * @test
     */
    public function shouldGetCommentsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Gist\Comments::class, $api->comments());
    }

    /**
     * @test
     */
    public function shouldForkGist()
    {
        $expectedArray = ['id' => '123'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/gists/123/fork')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->fork(123));
    }

    /**
     * @test
     */
    public function shouldListGistForks()
    {
        $expectedArray = ['id' => '123'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gists/123/forks')
            ->will($this->returnValue($expectedArray));

        $api->forks(123);
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateGistWithoutFile()
    {
        $input = [
            'description' => '',
            'public' => false,
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create($input);
    }

    /**
     * @test
     */
    public function shouldCheckGist()
    {
        $expectedArray = ['id' => '123'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gists/123/star')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->check(123));
    }

    /**
     * @test
     */
    public function shouldStarGist()
    {
        $expectedArray = ['id' => '123'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/gists/123/star')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->star(123));
    }

    /**
     * @test
     */
    public function shouldUnstarGist()
    {
        $expectedArray = ['id' => '123'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/gists/123/star')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->unstar(123));
    }

    /**
     * @test
     */
    public function shouldCreateAnonymousGist()
    {
        $input = [
            'description' => '',
            'public' => false,
            'files' => [
                'filename.txt' => [
                    'content' => 'content',
                ],
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/gists', $input);

        $api->create($input);
    }

    /**
     * @test
     */
    public function shouldUpdateGist()
    {
        $input = [
            'description' => 'jimbo',
            'files' => [
                'filename.txt' => [
                    'filename' => 'new_name.txt',
                    'content'  => 'content',
                ],
                'filename_new.txt' => [
                    'content'  => 'content new',
                ],
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/gists/5', $input);

        $api->update(5, $input);
    }

    /**
     * @test
     */
    public function shouldDeleteGist()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/gists/5');

        $api->remove(5);
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Gists::class;
    }
}
