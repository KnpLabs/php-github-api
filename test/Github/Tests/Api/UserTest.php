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
    public function shouldGetUserOrganizations()
    {
        $expectedArray = array(array(
            'id' => 202732,
            'url' => 'https://api.github.com/orgs/KnpLabs',
            'repos_url' => 'https://api.github.com/orgs/KnpLabs/repos',
            'events_url' => 'https://api.github.com/orgs/KnpLabs/events',
            'members_url' => 'https://api.github.com/orgs/KnpLabs/members{/member}',
            'public_members_url' => 'https://api.github.com/orgs/KnpLabs/public_members{/member}'
        ));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('users/l3l0/orgs')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->organizations('l3l0'));
    }

    /**
     * @test
     */
    public function shouldGetAllUsers()
    {
        $expectedArray = array(
            array('id' => 1, 'username' => 'l3l0'),
            array('id' => 2, 'username' => 'l3l0test')
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('users')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all());
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
    public function shouldGetSubscriptionsToRepositories()
    {
        $expectedArray = array(array('id' => 1, 'name' => 'l3l0repo'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('users/l3l0/subscriptions')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->subscriptions('l3l0'));
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
