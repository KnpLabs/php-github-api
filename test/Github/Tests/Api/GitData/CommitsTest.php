<?php

namespace Github\Tests\Api\GitData;

use Github\Exception\MissingArgumentException;
use Github\Tests\Api\TestCase;

class CommitsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowCommitUsingSha()
    {
        $expectedValue = ['sha' => '123', 'comitter'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/git/commits/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     */
    public function shouldCreateCommit()
    {
        $expectedValue = ['sha' => '123', 'comitter'];
        $data = ['message' => 'some message', 'tree' => 1234, 'parents' => []];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/git/commits', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldNotCreateCommitWithoutMessageParam()
    {
        $this->expectException(MissingArgumentException::class);
        $data = ['tree' => 1234, 'parents' => []];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldNotCreateCommitWithoutTreeParam()
    {
        $this->expectException(MissingArgumentException::class);
        $data = ['message' => 'some message', 'parents' => []];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldNotCreateCommitWithoutParentsParam()
    {
        $this->expectException(MissingArgumentException::class);
        $data = ['message' => 'some message', 'tree' => '12334'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\GitData\Commits::class;
    }
}
