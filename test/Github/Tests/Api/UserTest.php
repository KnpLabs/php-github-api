<?php

namespace Github\Tests\Api;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowUser()
    {
        $expectedArray = array('id' => 1, 'username' => 'l3l0');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('users/l3l0')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('l3l0'));
    }

    /**
     * @test
     */
    public function shouldSearchUsers()
    {
        $expectedArray = array(
            array('id' => 1, 'username' => 'l3l0'),
            array('id' => 2, 'username' => 'l3l0test')
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('legacy/user/search/l3l0')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->find('l3l0'));
    }

    /**
     * @test
     */
    public function shouldGetFollowingUsers()
    {
        $expectedArray = array(array('id' => 1, 'username' => 'l3l0test'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('users/l3l0/following')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->following('l3l0'));
    }

    /**
     * @test
     */
    public function shouldGetUserFollowers()
    {
        $expectedArray = array(array('id' => 1, 'username' => 'l3l0test'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('users/l3l0/followers')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->followers('l3l0'));
    }

    /**
     * @test
     */
    public function shouldGetWatchedRepositories()
    {
        $expectedArray = array(array('id' => 1, 'name' => 'l3l0repo'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('users/l3l0/watched')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->watched('l3l0'));
    }

    /**
     * @test
     */
    public function shouldGetUserRepositories()
    {
        $expectedArray = array(array('id' => 1, 'name' => 'l3l0repo'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('users/l3l0/repos')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->repositories('l3l0'));
    }

    /**
     * @test
     */
    public function shouldGetUserGists()
    {
        $expectedArray = array(array('id' => 1, 'name' => 'l3l0repo'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('users/l3l0/gists')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->gists('l3l0'));
    }

    protected function getApiClass()
    {
        return 'Github\Api\User';
    }
}
