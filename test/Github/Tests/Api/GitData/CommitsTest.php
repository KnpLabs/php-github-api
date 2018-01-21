<?php declare(strict_types=1);

namespace Github\Tests\Api;

use Github\Api\GitData\Commits;
use PHPUnit_Framework_MockObject_MockObject;

class CommitsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowCommitUsingSha()
    {
        $expectedValue = ['sha' => '123', 'comitter'];

        /** @var Commits|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/git/commits/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', '123'));
    }

    /**
     * @test
     */
    public function shouldCreateCommit()
    {
        $expectedValue = ['sha' => '123', 'comitter'];
        $data = ['message' => 'some message', 'tree' => 1234, 'parents' => []];

        /** @var Commits|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/git/commits', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateCommitWithoutMessageParam()
    {
        $data = ['tree' => 1234, 'parents' => []];

        /** @var Commits|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateCommitWithoutTreeParam()
    {
        $data = ['message' => 'some message', 'parents' => []];

        /** @var Commits|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateCommitWithoutParentsParam()
    {
        $data = ['message' => 'some message', 'tree' => '12334'];

        /** @var Commits|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    protected function getApiClass(): string
    {
        return Commits::class;
    }
}
