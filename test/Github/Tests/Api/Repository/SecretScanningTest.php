<?php

namespace Github\Tests\Api\Repository;

use Github\Api\Repository\SecretScanning;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class SecretScanningTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllAlerts()
    {
        $expectedArray = [
            ['number' => 1, 'state' => 'resolved', 'resolution' => 'false_positive'],
            ['number' => 2, 'state' => 'open', 'resolution' => null],
            ['number' => 3, 'state' => 'resolved', 'resolution' => 'wont_fix'],
            ['number' => 4, 'state' => 'resolved', 'resolution' => 'revoked'],
        ];

        /** @var SecretScanning|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/secret-scanning/alerts')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->alerts('KnpLabs', 'php-github-api', [
            'state' => 'all',
        ]));
    }

    /**
     * @test
     */
    public function shouldGetAlert()
    {
        $expectedArray = ['number' => 1, 'state' => 'resolved', 'resolution' => 'false_positive'];

        /** @var SecretScanning|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/secret-scanning/alerts/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->getAlert('KnpLabs', 'php-github-api', 1));
    }

    /**
     * @test
     */
    public function shouldUpdateAlert()
    {
        $expectedArray = ['number' => 1, 'state' => 'resolved', 'resolution' => 'false_positive'];

        /** @var SecretScanning|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/secret-scanning/alerts/2')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->updateAlert('KnpLabs', 'php-github-api', 2, [
            'state' => 'resolved',
            'resolution' => 'false_positive',
        ]));
    }

    /**
     * @test
     */
    public function shouldGetLocations()
    {
        $expectedArray = [
            [
                'type' => 'commit',
                'details' => [
                    'path' => '/example/secrets.txt',
                    'start_line' => 1,
                    'end_line' => 1,
                    'start_column' => 1,
                    'end_column' => 64,
                    'blob_sha' => 'af5626b4a114abcb82d63db7c8082c3c4756e51b',
                    'blob_url' => 'https://HOSTNAME/repos/octocat/hello-world/git/blobs/af5626b4a114abcb82d63db7c8082c3c4756e51b',
                    'commit_sha' => 'f14d7debf9775f957cf4f1e8176da0786431f72b',
                    'commit_url' => 'https://HOSTNAME/repos/octocat/hello-world/git/commits/f14d7debf9775f957cf4f1e8176da0786431f72b',
                ],
            ],
            [
                'type' => 'commit',
                'details' => [
                    'path' => '/example/secrets.txt',
                    'start_line' => 5,
                    'end_line' => 5,
                    'start_column' => 1,
                    'end_column' => 64,
                    'blob_sha' => '9def38117ab2d8355b982429aa924e268b4b0065',
                    'blob_url' => 'https://HOSTNAME/repos/octocat/hello-world/git/blobs/9def38117ab2d8355b982429aa924e268b4b0065',
                    'commit_sha' => '588483b99a46342501d99e3f10630cfc1219ea32',
                    'commit_url' => 'https://HOSTNAME/repos/octocat/hello-world/git/commits/588483b99a46342501d99e3f10630cfc1219ea32',
                ],
            ],
        ];

        /** @var SecretScanning|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/secret-scanning/alerts/2/locations')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->locations('KnpLabs', 'php-github-api', 2, [
            'per_page' => 10,
        ]));
    }

    protected function getApiClass()
    {
        return \Github\Api\Repository\SecretScanning::class;
    }
}
