<?php

namespace Github\Tests\Api;

class FollowersTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetFollowers()
    {
        $expectedValue = [
            ['login' => 'l3l0'],
            ['login' => 'cordoval'],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/following')
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
            ->with('/user/following/l3l0')
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
            ->with('/user/following/l3l0')
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
            ->with('/user/following/l3l0')
            ->will($this->returnValue(null));

        $this->assertNull($api->unfollow('l3l0'));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\CurrentUser\Followers::class;
    }
}
