<?php

namespace Github\Tests\Api\Issue;

use Github\Tests\Api\TestCase;

class CommentsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllIssueComments()
    {
        $expectedValue = [['comment1data'], ['comment2data']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/issues/123/comments', ['page' => 1])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     */
    public function shouldShowIssueComment()
    {
        $expectedValue = ['comment1'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/issues/comments/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateWithoutBody()
    {
        $data = [];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', '123', $data);
    }

    /**
     * @test
     */
    public function shouldCreateIssueComment()
    {
        $expectedValue = ['comment1data'];
        $data = ['body' => 'test body'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/issues/123/comments', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', '123', $data));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotUpdateWithoutBody()
    {
        $data = ['somedata'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('patch');

        $api->update('KnpLabs', 'php-github-api', '123', $data);
    }

    /**
     * @test
     */
    public function shouldUpdateIssueComment()
    {
        $expectedValue = ['comment1data'];
        $data = ['body' => 'body test'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/issues/comments/233', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', '233', $data));
    }

    /**
     * @test
     */
    public function shouldRemoveComment()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/issues/comments/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Issue\Comments::class;
    }
}
