<?php

namespace Github\Tests\Api;

class CurrentUserTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowCurrentUser()
    {
        $expectedArray = array('id' => 1, 'username' => 'l3l0');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('user')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show());
    }

    /**
     * @test
     */
    public function shouldUpdateCurrentUserData()
    {
        $expectedArray = array('id' => 1, 'username' => 'l3l0');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('user', array('value' => 'toChange'))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update(array('value' => 'toChange')));
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
            ->with('user/followers', array('page' => 1))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->followers(1));
    }

    /**
     * @test
     */
    public function shouldGetIssuesAssignedToUser()
    {
        $expectedArray = array(array('id' => 1, 'title' => 'issues'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('issues', array('page' => 1, 'some' => 'param'))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->issues(array('some' => 'param')));
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
            ->with('user/watched', array('page' => 1))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->watched(1));
    }

    /**
     * @test
     */
    public function shouldGetDeployKeysApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\CurrentUser\DeployKeys', $api->keys());
    }

    /**
     * @test
     */
    public function shouldGetEmailsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\CurrentUser\Emails', $api->emails());
    }

    /**
     * @test
     */
    public function shouldGetFollowersApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\CurrentUser\Followers', $api->follow());
    }

    /**
     * @test
     */
    public function shouldGetNotificationsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\CurrentUser\Notifications', $api->notifications());
    }

    /**
     * @test
     */
    public function shouldGetWatchersApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\CurrentUser\Watchers', $api->watchers());
    }

    protected function getApiClass()
    {
        return 'Github\Api\CurrentUser';
    }
}
