<?php declare(strict_types=1);

namespace Github\Tests\Api;

class FollowersTest extends TestCase
{
    public function shouldGetFollowers()
    {
        $expectedValue = [
            ['login' => 'l3l0'],
            ['login' => 'cordoval']
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/following')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all());
    }

    public function shouldCheckFollower()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/following/l3l0')
            ->will($this->returnValue(null));

        $this->assertNull($api->check('l3l0'));
    }

    public function shouldFollowUser()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/user/following/l3l0')
            ->will($this->returnValue(null));

        $this->assertNull($api->follow('l3l0'));
    }

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
    protected function getApiClass(): string
    {
        return \Github\Api\CurrentUser\Followers::class;
    }
}
