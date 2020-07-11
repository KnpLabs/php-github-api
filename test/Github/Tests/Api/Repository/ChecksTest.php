<?php

namespace Github\Tests\Api\Repository;

use Github\Exception\MissingArgumentException;
use Github\Tests\Api\TestCase;

class ChecksTest extends TestCase
{
    /**
     * @test
     */
    public function shouldNotCreateWithoutHeadSha()
    {
        $this->expectException(MissingArgumentException::class);
        $data = ['name' => 'my check'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldNotCreateWithoutName()
    {
        $this->expectException(MissingArgumentException::class);
        $data = ['head_sha' => 'commitSHA123456'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldCreateCheck()
    {
        $expectedValue = ['state' => 'success'];
        $data = ['head_sha' => 'commitSHA123456', 'name' => 'my check'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/check-runs', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldUpdateCheck()
    {
        $expectedValue = ['state' => 'success'];
        $data = ['head_sha' => 'commitSHA123456', 'name' => 'my check'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/check-runs/123', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', '123', $data));
    }

    /**
     * @test
     */
    public function shouldGetAllChecksForRef()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/commits/cb4abc15424c0015b4468d73df55efb8b60a4a3d/check-runs');

        $api->all('KnpLabs', 'php-github-api', 'cb4abc15424c0015b4468d73df55efb8b60a4a3d');
    }

    /**
     * @test
     */
    public function shouldShowSingleCheckRun()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/check-runs/14');

        $api->show('KnpLabs', 'php-github-api', 14);
    }

    /**
     * @test
     */
    public function shouldListCheckRunAnnotations()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/check-runs/14/annotations');

        $api->annotations('KnpLabs', 'php-github-api', 14);
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Repository\Checks::class;
    }
}
