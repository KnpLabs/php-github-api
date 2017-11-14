<?php declare(strict_types=1);

namespace Github\Tests\Api\Gist;

use Github\Tests\Api\TestCase;

class CommentsTest extends TestCase
{
    public function shouldGetAllGistComments()
    {
        $expectedValue = array(array('comment1data'), array('comment2data'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gists/123/comments')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('123'));
    }

    public function shouldShowGistComment()
    {
        $expectedValue = array('comment1');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gists/123/comments/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show(123, 123));
    }

    public function shouldCreateGistComment()
    {
        $expectedValue = array('comment1data');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/gists/123/comments', array('body' => 'Test body'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('123', 'Test body'));
    }

    public function shouldUpdateGistComment()
    {
        $expectedValue = array('comment1data');
        $data = array('body' => 'body test');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/gists/123/comments/233', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update(123, 233, 'body test'));
    }

    public function shouldRemoveComment()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/gists/123/comments/233')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove(123, 233));
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\Gist\Comments::class;
    }
}
