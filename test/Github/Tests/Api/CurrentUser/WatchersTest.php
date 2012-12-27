<?php

namespace Github\Tests\Api;

use Github\Tests\Api\TestCase;

class WatchersTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetWatchers()
    {
        $expectedValue = array(
            array('name' => 'l3l0/test'),
            array('name' => 'cordoval/test')
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('user/watched')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all());
    }

    /**
     * @test
     */
    public function shouldCheckWatcher()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('user/watched/l3l0/test')
            ->will($this->returnValue(null));

        $this->assertNull($api->check('l3l0', 'test'));
    }

    /**
     * @test
     */
    public function shouldWatchUser()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('user/watched/l3l0/test')
            ->will($this->returnValue(null));

        $this->assertNull($api->watch('l3l0', 'test'));
    }

    /**
     * @test
     */
    public function shouldUnwatchUser()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('user/watched/l3l0/test')
            ->will($this->returnValue(null));

        $this->assertNull($api->unwatch('l3l0', 'test'));
    }

    protected function getApiClass()
    {
        return 'Github\Api\CurrentUser\Watchers';
    }
}
