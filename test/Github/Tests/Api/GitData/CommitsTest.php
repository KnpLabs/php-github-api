<?php

namespace Github\Tests\Api;

use Github\Tests\Api\TestCase;

class CommitsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowCommitUsingSha()
    {
        $expectedValue = array('sha' => '123', 'comitter');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/commits/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     */
    public function shouldCreateCommit()
    {
        $expectedValue = array('sha' => '123', 'comitter');
        $data = array('message' => 'some message', 'tree' => 1234, 'parents' => array());

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('repos/KnpLabs/php-github-api/git/commits', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateCommitWithoutMessageParam()
    {
        $data = array('tree' => 1234, 'parents' => array());

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateCommitWithoutTreeParam()
    {
        $data = array('message' => 'some message', 'parents' => array());

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateCommitWithoutParentsParam()
    {
        $data = array('message' => 'some message', 'tree' => '12334');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    protected function getApiClass()
    {
        return 'Github\Api\GitData\Commits';
    }
}
