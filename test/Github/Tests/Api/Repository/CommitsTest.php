<?php declare(strict_types=1);

namespace Github\Tests\Api\Repository;

use Github\Api\Repository\Commits;
use Github\Tests\Api\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

class CommitsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllRepositoryCommits()
    {
        $expectedValue = ['commit' => [], 'comitter'];
        $data = ['sha' => 'v3'];

        /** @var Commits|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/commits', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldCompareTwoCommits()
    {
        $expectedValue = ['someCompareChanges'];

        /** @var Commits|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/compare/v3...HEAD')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->compare('KnpLabs', 'php-github-api', 'v3', 'HEAD'));
    }

    /**
     * @test
     */
    public function shouldShowCommitUsingSha()
    {
        $expectedValue = ['sha' => '123', 'comitter'];

        /** @var Commits|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/commits/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', '123'));
    }

    protected function getApiClass(): string
    {
        return Commits::class;
    }
}
