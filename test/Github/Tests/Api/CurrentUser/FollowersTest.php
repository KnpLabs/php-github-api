<?php

namespace Github\Tests\Api;

use Github\Tests\Api\TestCase;

class FollowersTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetFollowers()
    {
        $expectedValue = array(
            array('login' => 'l3l0'),
            array('login' => 'cordoval')
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('user/following')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all());
    }

    /**
     * @test
     */
    public function shouldCheckFollower()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('user/following/l3l0')
            ->will($this->returnValue(null));

        $this->assertNull($api->check('l3l0'));
    }

    /**
     * @test
     */
    public function shouldFollowUser()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('user/following/l3l0')
            ->will($this->returnValue(null));

        $this->assertNull($api->follow('l3l0'));
    }

    /**
     * @test
     */
    public function shouldUnfollowUser()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('user/following/l3l0')
            ->will($this->returnValue(null));

        $this->assertNull($api->unfollow('l3l0'));
    }

    protected function getApiClass()
    {
        return 'Github\Api\CurrentUser\Followers';
    }
}
