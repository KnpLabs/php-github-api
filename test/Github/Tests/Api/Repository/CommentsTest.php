<?php

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class CommentsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllRepositoryComments()
    {
        $expectedValue = array(array('comment1data'), array('comment2data'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/comments')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetSpecificCommitRepositoryComments()
    {
        $expectedValue = array(array('comment1data'), array('comment2data'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/commits/commitSHA123456/comments')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', 'commitSHA123456'));
    }

    /**
     * @test
     */
    public function shouldShowComment()
    {
        $expectedValue = array('comment1');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/comments/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateWithoutBody()
    {
        $data = array('line' => 53, 'path' => 'test.php', 'position' => 2);

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', 'commitSHA123456', $data);
    }

    /**
     * @test
     */
    public function shouldCreateRepositoryCommitComment()
    {
        $expectedValue = array('comment1data');
        $data = array('body' => 'test body', 'line' => 53, 'path' => 'test.php', 'position' => 2);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('repos/KnpLabs/php-github-api/commits/commitSHA123456/comments', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', 'commitSHA123456', $data));
    }

    /**
     * @test
     */
    public function shouldCreateRepositoryCommitCommentWithoutLine()
    {
        $expectedValue = array('comment1data');
        $data = array('body' => 'body', 'path' => 'test.php', 'position' => 2);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('repos/KnpLabs/php-github-api/commits/commitSHA123456/comments', $data)
            ->will($this->returnValue($expectedValue));

        $api->create('KnpLabs', 'php-github-api', 'commitSHA123456', $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotUpdateWithoutBody()
    {
        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('patch');

        $api->update('KnpLabs', 'php-github-api', 'commitSHA123456', array());
    }

    /**
     * @test
     */
    public function shouldUpdateComment()
    {
        $expectedValue = array('comment1data');
        $data = array('body' => 'body test');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('repos/KnpLabs/php-github-api/comments/123', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 123, $data));
    }

    /**
     * @test
     */
    public function shouldRemoveComment()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('repos/KnpLabs/php-github-api/comments/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 123));
    }

    protected function getApiClass()
    {
        return 'Github\Api\Repository\Comments';
    }
}
