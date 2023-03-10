<?php

namespace Github\Tests\Api\Organization\Actions;

use Github\Api\Organization\Actions\SelfHostedRunners;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class SelfHostedRunnersTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetSelfHostedRunners()
    {
        $expectedArray = [
            [
                'id' => 1,
                'name' => 'MBP',
                'os' => 'macos',
                'status' => 'online',
            ],
            [
                'id' => 2,
                'name' => 'iMac',
                'os' => 'macos',
                'status' => 'offline',
            ],
        ];

        /** @var SelfHostedRunners|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/actions/runners')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldGetSelfHostedRunner()
    {
        $expectedArray = [
            'id' => 1,
            'name' => 'MBP',
            'os' => 'macos',
            'status' => 'online',
        ];

        /** @var SelfHostedRunners|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/actions/runners/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('KnpLabs', 1));
    }

    /**
     * @test
     */
    public function shouldRemoveSelfHostedRunner()
    {
        $expectedValue = 'response';

        /** @var SelfHostedRunners|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('delete')
            ->with('/orgs/KnpLabs/actions/runners/1')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 1));
    }

    /**
     * @test
     */
    public function shouldGetSelfHostedRunnerApps()
    {
        $expectedArray = [
            ['os' => 'osx', 'architecture' => 'x64', 'download_url' => 'download_url', 'filename' => 'filename'],
            ['os' => 'linux', 'architecture' => 'x64', 'download_url' => 'download_url', 'filename' => 'filename'],
            ['os' => 'linux', 'architecture' => 'arm', 'download_url' => 'download_url', 'filename' => 'filename'],
            ['os' => 'win', 'architecture' => 'x64', 'download_url' => 'download_url', 'filename' => 'filename'],
            ['os' => 'linux', 'architecture' => 'arm64', 'download_url' => 'download_url', 'filename' => 'filename'],
        ];

        /** @var SelfHostedRunners|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/actions/runners/downloads')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->applications('KnpLabs'));
    }

    protected function getApiClass()
    {
        return SelfHostedRunners::class;
    }
}
