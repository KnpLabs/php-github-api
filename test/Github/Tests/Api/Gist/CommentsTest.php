<?php declare(strict_types=1);

namespace Github\Tests\Api\Gist;

use Github\Tests\Api\TestCase;

class CommentsTest extends TestCase
{
    public function shouldGetAllGistComments()
    {
        $expectedValue = [['comment1data'], ['comment2data']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gists/123/comments')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('123'));
    }

    public function shouldShowGistComment()
    {
        $expectedValue = ['comment1'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gists/123/comments/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show(123, 123));
    }

    public function shouldCreateGistComment()
    {
        $expectedValue = ['comment1data'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/gists/123/comments', ['body' => 'Test body'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('123', 'Test body'));
    }

    public function shouldUpdateGistComment()
    {
        $expectedValue = ['comment1data'];
        $data = ['body' => 'body test'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/gists/123/comments/233', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update(123, 233, 'body test'));
    }

    public function shouldRemoveComment()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/gists/123/comments/233')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove(123, 233));
    }

    protected function getApiClass(): string
    {
        return \Github\Api\Gist\Comments::class;
    }
}
