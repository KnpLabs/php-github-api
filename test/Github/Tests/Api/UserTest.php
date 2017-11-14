<?php declare(strict_types=1);

namespace Github\Tests\Api;

class UserTest extends TestCase
{
    public function shouldShowUser()
    {
        $expectedArray = ['id' => 1, 'username' => 'l3l0'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/users/l3l0')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('l3l0'));
    }

    public function shouldGetUserOrganizations()
    {
        $expectedArray = [[
            'id' => 202732,
            'url' => 'https://api.github.com/orgs/KnpLabs',
            'repos_url' => 'https://api.github.com/orgs/KnpLabs/repos',
            'events_url' => 'https://api.github.com/orgs/KnpLabs/events',
            'members_url' => 'https://api.github.com/orgs/KnpLabs/members{/member}',
            'public_members_url' => 'https://api.github.com/orgs/KnpLabs/public_members{/member}'
        ]];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/users/l3l0/orgs')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->organizations('l3l0'));
    }

    public function shouldGetUserOrgs()
    {
        $expectedArray = [[
            'id' => 202732,
            'url' => 'https://api.github.com/orgs/KnpLabs',
            'repos_url' => 'https://api.github.com/orgs/KnpLabs/repos',
            'events_url' => 'https://api.github.com/orgs/KnpLabs/events',
            'members_url' => 'https://api.github.com/orgs/KnpLabs/members{/member}',
            'public_members_url' => 'https://api.github.com/orgs/KnpLabs/public_members{/member}'
        ]];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/orgs')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->orgs());
    }

    public function shouldGetAllUsers()
    {
        $expectedArray = [
            ['id' => 1, 'username' => 'l3l0'],
            ['id' => 2, 'username' => 'l3l0test']
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/users')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all());
    }

    public function shouldGetAllUsersSince()
    {
        $expectedArray = [
            ['id' => 3, 'username' => 'test3'],
            ['id' => 4, 'username' => 'test4']
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/users', ['since' => 2])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all(2));
    }

    public function shouldSearchUsers()
    {
        $expectedArray = [
            ['id' => 1, 'username' => 'l3l0'],
            ['id' => 2, 'username' => 'l3l0test']
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/legacy/user/search/l3l0')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->find('l3l0'));
    }

    public function shouldGetFollowingUsers()
    {
        $expectedArray = [['id' => 1, 'username' => 'l3l0test']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/users/l3l0/following')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->following('l3l0'));
    }

    public function shouldGetUserFollowers()
    {
        $expectedArray = [['id' => 1, 'username' => 'l3l0test']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/users/l3l0/followers')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->followers('l3l0'));
    }

    public function shouldGetStarredToRepositories()
    {
        $expectedArray = [['id' => 1, 'name' => 'l3l0repo']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/users/l3l0/starred', ['page' => 2, 'per_page' => 30, 'sort' => 'created', 'direction' => 'desc'])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->starred('l3l0', 2));
    }

    public function shouldGetSubscriptionsToRepositories()
    {
        $expectedArray = [['id' => 1, 'name' => 'l3l0repo']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/users/l3l0/subscriptions')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->subscriptions('l3l0'));
    }

    public function shouldGetUserRepositories()
    {
        $expectedArray = [['id' => 1, 'name' => 'l3l0repo']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/users/l3l0/repos', ['type' => 'owner', 'sort' => 'full_name', 'direction' => 'asc'])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->repositories('l3l0'));
    }

    public function shouldGetMyRepositories()
    {
        $expectedArray = [['id' => 1, 'name' => 'l3l0repo']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')->with('/user/repos', [])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->myRepositories());
    }

    public function shouldGetUserGists()
    {
        $expectedArray = [['id' => 1, 'name' => 'l3l0repo']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/users/l3l0/gists')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->gists('l3l0'));
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\User::class;
    }
}
