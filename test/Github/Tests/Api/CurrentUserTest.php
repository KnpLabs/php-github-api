<?php declare(strict_types=1);

namespace Github\Tests\Api;

use Github\Api\CurrentUser;
use PHPUnit_Framework_MockObject_MockObject;

class CurrentUserTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowCurrentUser()
    {
        $expectedArray = ['id' => 1, 'username' => 'l3l0'];

        /** @var CurrentUser|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show());
    }

    /**
     * @test
     */
    public function shouldUpdateCurrentUserData()
    {
        $expectedArray = ['id' => 1, 'username' => 'l3l0'];

        /** @var CurrentUser|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/user', ['value' => 'toChange'])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update(['value' => 'toChange']));
    }

    /**
     * @test
     */
    public function shouldGetUserFollowers()
    {
        $expectedArray = [['id' => 1, 'username' => 'l3l0test']];

        /** @var CurrentUser|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/followers', ['page' => 1])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->followers(1));
    }

    /**
     * @test
     */
    public function shouldGetIssuesAssignedToUser()
    {
        $expectedArray = [['id' => 1, 'title' => 'issues']];

        /** @var CurrentUser|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/issues', ['page' => 1, 'some' => 'param'])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->issues(['some' => 'param']));
    }

    /**
     * @test
     */
    public function shouldGetWatchedRepositories()
    {
        $expectedArray = [['id' => 1, 'name' => 'l3l0repo']];

        /** @var CurrentUser|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/watched', ['page' => 1])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->watched(1));
    }

    /**
     * @test
     */
    public function shouldGetInstallations()
    {
        $result = ['installation1', 'installation2'];

        /** @var CurrentUser|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/installations')
            ->willReturn($result);

        $this->assertEquals($result, $api->installations());
    }

    /**
     * @test
     */
    public function shouldGetRepositoriesByInstallation()
    {
        $expectedArray = [['id' => 1, 'name' => 'l3l0repo']];

        /** @var CurrentUser|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/installations/42/repositories', ['page' => 1])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->repositoriesByInstallation('42'));
    }

    /**
     * @test
     */
    public function shouldGetDeployKeysApiObject()
    {
        /** @var CurrentUser|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\CurrentUser\PublicKeys::class, $api->keys());
    }

    /**
     * @test
     */
    public function shouldGetEmailsApiObject()
    {
        /** @var CurrentUser|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\CurrentUser\Emails::class, $api->emails());
    }

    /**
     * @test
     */
    public function shouldGetFollowersApiObject()
    {
        /** @var CurrentUser|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\CurrentUser\Followers::class, $api->follow());
    }

    /**
     * @test
     */
    public function shouldGetNotificationsApiObject()
    {
        /** @var CurrentUser|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\CurrentUser\Notifications::class, $api->notifications());
    }

    /**
     * @test
     */
    public function shouldGetWatchersApiObject()
    {
        /** @var CurrentUser|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\CurrentUser\Watchers::class, $api->watchers());
    }

    /**
     * @test
     */
    public function shouldGetStarredApiObject()
    {
        /** @var CurrentUser|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\CurrentUser\Starring::class, $api->starring());
    }

    protected function getApiClass(): string
    {
        return CurrentUser::class;
    }
}
