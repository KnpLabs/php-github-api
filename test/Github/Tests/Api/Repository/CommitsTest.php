<?php

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class CommitsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllRepositoryCommits()
    {
        $expectedValue = array('commit' => array(), 'comitter');
        $data = array('sha' => 'v3');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/commits', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldCompareTwoCommits()
    {
        $expectedValue = array('someCompareChanges');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/compare/v3...HEAD')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->compare('KnpLabs', 'php-github-api', 'v3', 'HEAD'));
    }

    /**
     * @test
     */
    public function shouldShowCommitUsingSha()
    {
        $expectedValue = array('sha' => '123', 'comitter');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/commits/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    protected function getApiClass()
    {
        return 'Github\Api\Repository\Commits';
    }
}
