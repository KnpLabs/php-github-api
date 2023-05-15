<?php

namespace Github\Tests\Api\User;

use Github\Api\User\Migration;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class MigrationTest extends TestCase
{
    /**
     * @test
     */
    public function shouldListUserMigrations()
    {
        $expectedArray = [
            [
                'id' => 79,
                'state' => 'pending',
                'lock_repositories' => true,
                'repositories' => [
                    [
                        'id' => 1296269,
                        'name' => 'Hello-World',
                        'full_name' => 'octocat/Hello-World',
                    ],
                ],
            ],
            [
                'id' => 2,
                'name' => 'pending',
                'lock_repositories' => false,
                'repositories' => [
                    [
                        'id' => 123,
                        'name' => 'php-github-api',
                        'full_name' => 'KnpLabs/php-github-api',
                    ],
                ],
            ],
        ];

        /** @var Migration|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/user/migrations')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->list());
    }

    /**
     * @test
     */
    public function shouldStartMigration()
    {
        $expectedArray = [
            'id' => 79,
            'state' => 'pending',
            'lock_repositories' => true,
            'repositories' => [
                [
                    'id' => 1296269,
                    'name' => 'Hello-World',
                    'full_name' => 'octocat/Hello-World',
                ],
            ],
        ];

        /** @var Migration|MockObject $api */
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('post')
            ->with('/user/migrations')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->start([
            'lock_repositories' => true,
            'repositories' => [
                'KnpLabs/php-github-api',
            ],
        ]));
    }

    /**
     * @test
     */
    public function shouldGetMigrationStatus()
    {
        $expectedArray = [
            'id' => 79,
            'state' => 'exported',
            'lock_repositories' => true,
            'repositories' => [
                [
                    'id' => 1296269,
                    'name' => 'Hello-World',
                    'full_name' => 'octocat/Hello-World',
                ],
            ],
        ];

        /** @var Migration|MockObject $api */
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('/user/migrations/79')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->status(79));
    }

    /**
     * @test
     */
    public function shouldDeleteMigrationArchive()
    {
        /** @var Migration|MockObject $api */
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('delete')
            ->with('/user/migrations/79/archive')
            ->will($this->returnValue(204));

        $this->assertEquals(204, $api->deleteArchive(79));
    }

    /**
     * @test
     */
    public function shouldUnlockUserRepo()
    {
        /** @var Migration|MockObject $api */
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('delete')
            ->with('/user/migrations/79/repos/php-github-api/lock')
            ->will($this->returnValue(204));

        $this->assertEquals(204, $api->unlockRepo(79, 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldListRepos()
    {
        $expectedArray = [
            [
                'id' => 1296269,
                'name' => 'Hello-World',
                'full_name' => 'test/Hello-World',
            ],
            [
                'id' => 234324,
                'name' => 'Hello-World2',
                'full_name' => 'test/Hello-World2',
            ],
        ];

        /** @var Migration|MockObject $api */
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('/user/migrations/79/repositories')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->repos(79));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\User\Migration::class;
    }
}
