<?php declare(strict_types=1);

namespace Github\Tests\Api;

class CurrentUserTest extends TestCase
{
    public function shouldShowCurrentUser()
    {
        $expectedArray = ['id' => 1, 'username' => 'l3l0'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show());
    }

    public function shouldUpdateCurrentUserData()
    {
        $expectedArray = ['id' => 1, 'username' => 'l3l0'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/user', ['value' => 'toChange'])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update(['value' => 'toChange']));
    }

    public function shouldGetUserFollowers()
    {
        $expectedArray = [['id' => 1, 'username' => 'l3l0test']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/followers', ['page' => 1])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->followers(1));
    }

    public function shouldGetIssuesAssignedToUser()
    {
        $expectedArray = [['id' => 1, 'title' => 'issues']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/issues', ['page' => 1, 'some' => 'param'])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->issues(['some' => 'param']));
    }

    public function shouldGetWatchedRepositories()
    {
        $expectedArray = [['id' => 1, 'name' => 'l3l0repo']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/watched', ['page' => 1])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->watched(1));
    }

    public function shouldGetInstallations()
    {
        $result = ['installation1', 'installation2'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/installations')
            ->willReturn($result);

        $this->assertEquals($result, $api->installations());
    }

    public function shouldGetRepositoriesByInstallation()
    {
        $expectedArray = [['id' => 1, 'name' => 'l3l0repo']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/installations/42/repositories', ['page' => 1])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->repositoriesByInstallation(42));
    }

    public function shouldGetDeployKeysApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\CurrentUser\PublicKeys::class, $api->keys());
    }

    public function shouldGetEmailsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\CurrentUser\Emails::class, $api->emails());
    }

    public function shouldGetFollowersApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\CurrentUser\Followers::class, $api->follow());
    }

    public function shouldGetNotificationsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\CurrentUser\Notifications::class, $api->notifications());
    }

    public function shouldGetWatchersApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\CurrentUser\Watchers::class, $api->watchers());
    }

    public function shouldGetStarredApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\CurrentUser\Starring::class, $api->starring());
    }

    protected function getApiClass(): string
    {
        return \Github\Api\CurrentUser::class;
    }
}
