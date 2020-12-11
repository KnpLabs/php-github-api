<?php

namespace Github\Tests\Api\Repository\Actions;

use Github\Api\Repository\Actions\Artifacts;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class ArtifactsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetArtifacts()
    {
        $expectedArray = [
            [
                'id' => 'id',
                'node_id' => 'node_id',
                'name' => 'name',
                'size_in_bytes' => 453,
                'url' => 'foo',
                'archive_download_url' => 'foo',
                'expired' => false,
                'created_at' => '2020-01-10T14:59:22Z',
                'expires_at' => '2020-01-21T14:59:22Z',
            ],
        ];

        /** @var Artifacts|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/actions/artifacts')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetRunArtifacts()
    {
        $expectedArray = [
            [
                'id' => 'id',
                'node_id' => 'node_id',
                'name' => 'name',
                'size_in_bytes' => 453,
                'url' => 'foo',
                'archive_download_url' => 'foo',
                'expired' => false,
                'created_at' => '2020-01-10T14:59:22Z',
                'expires_at' => '2020-01-21T14:59:22Z',
            ],
        ];

        /** @var Artifacts|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/actions/runs/1/artifacts')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->runArtifacts('KnpLabs', 'php-github-api', 1));
    }

    /**
     * @test
     */
    public function shouldRemoveArtifact()
    {
        $expectedValue = 'response';

        /** @var Artifacts|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/actions/artifacts/1')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 1));
    }

    protected function getApiClass()
    {
        return Artifacts::class;
    }
}
