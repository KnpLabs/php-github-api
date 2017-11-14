<?php declare(strict_types=1);

namespace Github\Tests\Api;

class GistsTest extends TestCase
{
    public function shouldGetStarredGists()
    {
        $expectedArray = array(array('id' => '123'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gists/starred')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('starred'));
    }

    public function shouldGetAllGists()
    {
        $expectedArray = array(array('id' => '123'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gists')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all());
    }

    public function shouldShowGist()
    {
        $expectedArray = array('id' => '123');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gists/123')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show(123));
    }

    public function shouldShowCommits()
    {
        $expectedArray = array('id' => '123');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gists/123/commits')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->commits(123));
    }

    public function shouldGetCommentsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Gist\Comments::class, $api->comments());
    }

    public function shouldForkGist()
    {
        $expectedArray = array('id' => '123');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/gists/123/fork')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->fork(123));
    }

    public function shouldListGistForks()
    {
        $expectedArray = array('id' => '123');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gists/123/forks')
            ->will($this->returnValue($expectedArray));

        $api->forks(123);
    }

    public function shouldNotCreateGistWithoutFile()
    {
        $input = array(
            'description' => '',
            'public' => false,
        );

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create($input);
    }

    public function shouldCheckGist()
    {
        $expectedArray = array('id' => '123');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gists/123/star')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->check(123));
    }

    public function shouldStarGist()
    {
        $expectedArray = array('id' => '123');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/gists/123/star')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->star(123));
    }

    public function shouldUnstarGist()
    {
        $expectedArray = array('id' => '123');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/gists/123/star')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->unstar(123));
    }

    public function shouldCreateAnonymousGist()
    {
        $input = array(
            'description' => '',
            'public' => false,
            'files' => array(
                'filename.txt' => array(
                    'content' => 'content'
                )
            )
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/gists', $input);

        $api->create($input);
    }

    public function shouldUpdateGist()
    {
        $input = array(
            'description' => 'jimbo',
            'files' => array(
                'filename.txt' => array(
                    'filename' => 'new_name.txt',
                    'content'  => 'content'
                ),
                'filename_new.txt' => array(
                    'content'  => 'content new'
                )
            )
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/gists/5', $input);

        $api->update(5, $input);
    }

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
    protected function getApiClass(): string
    {
        return \Github\Api\Gists::class;
    }
}
