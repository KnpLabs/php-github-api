<?php

use Github\Tests\Api\TestCase;

class TrafficTest extends TestCase
{
    /**
     * @test
     */
    public function shouldgetReferers()
    {
        $expectedValue = json_encode(['referrer' => 'github.com', 'count' => 112, 'uniques' => 15]);

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('/repos/knplabs/php-github-api/traffic/popular/referrers')
            ->will($this->returnValue($expectedValue));

        $result = $api->referers('knplabs', 'php-github-api');

        $this->assertEquals($expectedValue, $result);
    }

    public function shouldgetPaths()
    {
        $expectedValue = json_encode(['path' => '/knplabs/php-github-api', 'title' => 'KnpLabs/php-github-api: A simple PHP GitHub API client, Object Oriented, tested and documented. For 5.5+.', 'count' => 203, 'uniques' => 54]);

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('/repos/knplabs/php-github-api/traffic/popular/paths')
            ->will($this->returnValue($expectedValue));

        $result = $api->paths('knplabs', 'php-github-api');

        $this->assertEquals($expectedValue, $result);
    }

    public function shouldgetViews()
    {
        $expectedValue = json_encode(['count' => 813, 'uniques' => 61, 'views' => [['timestamp' => '2017-03-12T00:00:00Z', 'count' => 40, 'uniques' => 3]]]);

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('/repos/knplabs/php-github-api/traffic/views?per=day')
            ->will($this->returnValue($expectedValue));

        $result = $api->views('knplabs', 'php-github-api');

        $this->assertEquals($expectedValue, $result);
    }

    public function shouldgetClones()
    {
        $expectedValue = json_encode(['count' => 813, 'uniques' => 61, 'clones' => [['timestamp' => '2017-03-12T00:00:00Z', 'count' => 14, 'uniques' => 8]]]);

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('/repos/knplabs/php-github-api/traffic/clones?per=day')
            ->will($this->returnValue($expectedValue));

        $result = $api->clones('knplabs', 'php-github-api');

        $this->assertEquals($expectedValue, $result);
    }

    protected function getApiClass()
    {
        return \Github\Api\Repository\Traffic::class;
    }
}
