<?php

declare(strict_types=1);

namespace Github\Api\App;

use Github\Tests\Api\TestCase;

class HookTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowHookConfiguration()
    {
        $result = [
            'content_type' => 'json',
            'insecure_ssl' => 0,
            'secret' => '********',
            'url' => 'https://localhost/',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/app/hook/config', [])
            ->willReturn($result);

        $this->assertEquals($result, $api->showConfig());
    }

    /**
     * @test
     */
    public function shouldUpdateHookConfiguration()
    {
        $parameters = [
            'content_type' => 'json',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/app/hook/config', $parameters)
            ->willReturn([]);

        $this->assertEquals([], $api->updateConfig($parameters));
    }

    /**
     * @test
     */
    public function shouldListHookDelivieries()
    {
        $result = [];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/app/hook/deliveries', [])
            ->willReturn($result);

        $this->assertEquals($result, $api->deliveries());
    }

    /**
     * @test
     */
    public function shouldListHookDeliviery()
    {
        $result = [];

        $delivery = 1234567;

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/app/hook/deliveries/'.$delivery, [])
            ->willReturn($result);

        $this->assertEquals($result, $api->delivery($delivery));
    }

    /**
     * @test
     */
    public function shouldRedeliveryHook()
    {
        $result = [];

        $delivery = 1234567;

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/app/hook/deliveries/'.$delivery.'/attempts', [])
            ->willReturn($result);

        $this->assertEquals($result, $api->redeliver($delivery));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\App\Hook::class;
    }
}
