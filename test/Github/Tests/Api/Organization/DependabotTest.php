<?php

namespace Github\Tests\Api\Organization;

use Github\Api\Organization\SecretScanning;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class DependabotTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAlerts()
    {
        $expectedArray = [
            ['number' => 1, 'state' => 'open', 'severity' => 'critical'],
        ];

        /** @var SecretScanning|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/dependabot/alerts')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->alerts('KnpLabs', [
            'severity' => 'critical',
        ]));
    }

    protected function getApiClass()
    {
        return \Github\Api\Organization\Dependabot::class;
    }
}
