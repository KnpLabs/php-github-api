<?php

namespace Github\Tests\Api\Enterprise;

use Github\Api\Enterprise\SecretScanning;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class SecretScanningTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAlerts()
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
            ->with('/enterprises/KnpLabs/secret-scanning/alerts')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->alerts('KnpLabs', [
            'state' => 'all',
        ]));
    }

    protected function getApiClass()
    {
        return \Github\Api\Enterprise\SecretScanning::class;
    }
}
