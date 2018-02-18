<?php

namespace Github\Tests;

use Github\Api\Organization\Members;
use Github\Api\Search;
use Github\ResultPager;
use Github\Tests\Mock\PaginatedResponse;
use Http\Client\HttpClient;

/**
 * ResultPagerTest.
 *
 * @author Ramon de la Fuente <ramon@future500.nl>
 * @author Mitchel Verschoof <mitchel@future500.nl>
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class ResultPagerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * description fetchAll
     */
    public function shouldGetAllResults()
    {
        $amountLoops = 3;
        $content = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $response = new PaginatedResponse($amountLoops, $content);

        // httpClient mock
        $httpClientMock = $this->getMockBuilder(\Http\Client\HttpClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $httpClientMock
            ->expects($this->exactly($amountLoops))
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $client = \Github\Client::createWithHttpClient($httpClientMock);

        // memberApi Mock
        $memberApi = new Members($client);

        $method = 'all';
        $parameters = ['netwerven'];

        // Run fetchAll on result paginator
        $paginator = new ResultPager($client);
        $result = $paginator->fetchAll($memberApi, $method, $parameters);

        $this->assertCount($amountLoops * count($content), $result);
    }

    /**
     * @test
     *
     * response in a search api has different format:
     *
     * {
     *  "total_count": 1,
     *  "incomplete_results": false,
     *  "items": []
     * }
     *
     * and we need to extract result from `items`
     */
    public function shouldGetAllSearchResults()
    {
        $amountLoops = 3;

        $content = [
            'total_count' => 12,
            'items' => [1, 2, 3, 4],
        ];
        $response = new PaginatedResponse($amountLoops, $content);

        // httpClient mock
        $httpClientMock = $this->getMockBuilder(\Http\Client\HttpClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $httpClientMock
            ->expects($this->exactly($amountLoops))
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $client = \Github\Client::createWithHttpClient($httpClientMock);

        $searchApi = new Search($client);
        $method = 'users';
        $paginator = new ResultPager($client);
        $result = $paginator->fetchAll($searchApi, $method, ['knplabs']);

        $this->assertCount($amountLoops * count($content['items']), $result);
    }

    public function testFetch()
    {
        $result = 'foo';
        $method = 'bar';
        $parameters = ['baz'];
        $api = $this->getMockBuilder(\Github\Api\ApiInterface::class)
            ->getMock();

        $paginator = $this->getMockBuilder(\Github\ResultPager::class)
            ->disableOriginalConstructor()
            ->setMethods(['callApi', 'postFetch'])
            ->getMock();
        $paginator->expects($this->once())
            ->method('callApi')
            ->with($api, $method, $parameters)
            ->willReturn($result);

        $paginator->expects($this->once())
            ->method('postFetch');

        $this->assertEquals($result, $paginator->fetch($api, $method, $parameters));
    }
}
