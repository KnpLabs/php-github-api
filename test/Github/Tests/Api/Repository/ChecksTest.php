<?php

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class ChecksTest extends TestCase
{
    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateWithoutHeadSha()
    {
        $data = ['name' => 'my check'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateWithoutName()
    {
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
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Repository\Checks::class;
    }
}
