<?php declare(strict_types=1);

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class CommentsTest extends TestCase
{
    public function shouldGetAllRepositoryComments()
    {
        $expectedValue = [['comment1data'], ['comment2data']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/comments')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    public function shouldGetSpecificCommitRepositoryComments()
    {
        $expectedValue = [['comment1data'], ['comment2data']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/commits/commitSHA123456/comments')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', 'commitSHA123456'));
    }

    public function shouldShowComment()
    {
        $expectedValue = ['comment1'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/comments/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    public function shouldNotCreateWithoutBody()
    {
        $data = ['line' => 53, 'path' => 'test.php', 'position' => 2];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', 'commitSHA123456', $data);
    }

    public function shouldCreateRepositoryCommitComment()
    {
        $expectedValue = ['comment1data'];
        $data = ['body' => 'test body', 'line' => 53, 'path' => 'test.php', 'position' => 2];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/commits/commitSHA123456/comments', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', 'commitSHA123456', $data));
    }

    public function shouldCreateRepositoryCommitCommentWithoutLine()
    {
        $expectedValue = ['comment1data'];
        $data = ['body' => 'body', 'path' => 'test.php', 'position' => 2];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/commits/commitSHA123456/comments', $data)
            ->will($this->returnValue($expectedValue));

        $api->create('KnpLabs', 'php-github-api', 'commitSHA123456', $data);
    }

    public function shouldNotUpdateWithoutBody()
    {
        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('patch');

        $api->update('KnpLabs', 'php-github-api', 'commitSHA123456', []);
    }

    public function shouldUpdateComment()
    {
        $expectedValue = ['comment1data'];
        $data = ['body' => 'body test'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/comments/123', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 123, $data));
    }

    public function shouldRemoveComment()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/comments/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\Repository\Comments::class;
    }
}
