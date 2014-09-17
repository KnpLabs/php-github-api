<?php

namespace Github\Tests\Api;

use Github\Tests\Api\TestCase;

class StarringTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetStarred()
    {
        $expectedValue = array(
            array('name' => 'l3l0/test'),
            array('name' => 'cordoval/test')
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('user/starred')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all());
    }

    /**
     * @test
     */
    public function shouldCheckStar()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('user/starred/l3l0/test')
            ->will($this->returnValue(null));

        $this->assertNull($api->check('l3l0', 'test'));
    }

    /**
     * @test
     */
    public function shouldStarUser()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('user/starred/l3l0/test')
            ->will($this->returnValue(null));

        $this->assertNull($api->star('l3l0', 'test'));
    }

    /**
     * @test
     */
    public function shouldUnstarUser()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('user/starred/l3l0/test')
            ->will($this->returnValue(null));

        $this->assertNull($api->unstar('l3l0', 'test'));
    }

    protected function getApiClass()
    {
        return 'Github\Api\CurrentUser\Starring';
    }
}
