<?php

namespace Github\Tests;

use Github\Api\Organization\Members;
use Github\Api\Search;
use Github\ResultPager;
use Github\Tests\Mock\PaginatedResponse;
use Http\Client\HttpClient;
use Psr\Http\Client\ClientInterface;

/**
 * @author Ramon de la Fuente <ramon@future500.nl>
 * @author Mitchel Verschoof <mitchel@future500.nl>
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class ResultPagerTest extends \PHPUnit\Framework\TestCase
{
    public function provideFetchCases()
    {
        return [
            ['fetchAll'],
            ['fetchAllLazy'],
        ];
    }

    /**
     * @test provideFetchCases
     *
     * @dataProvider provideFetchCases
     */
    public function shouldGetAllResults(string $fetchMethod)
    {
        $amountLoops = 3;
        $content = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $response = new PaginatedResponse($amountLoops, $content);

        // httpClient mock
        $httpClientMock = $this->getMockBuilder(ClientInterface::class)
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

        $result = $paginator->$fetchMethod($memberApi, $method, $parameters);

        if (is_array($result)) {
            $this->assertSame('fetchAll', $fetchMethod);
        } else {
            $result = iterator_to_array($result);
        }

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
        $httpClientMock = $this->getMockBuilder(ClientInterface::class)
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
        $result = ['foo'];
        $method = 'all';
        $parameters = ['baz'];
        $api = $this->getMockBuilder(Members::class)
            ->disableOriginalConstructor()
            ->setMethods(['all'])
            ->getMock();
        $api->expects($this->once())
            ->method('all')
            ->with(...$parameters)
            ->willReturn($result);

        $paginator = $this->getMockBuilder(ResultPager::class)
            ->disableOriginalConstructor()
            ->setMethods(['postFetch'])
            ->getMock();

        $paginator->expects($this->once())
            ->method('postFetch');

        $this->assertEquals($result, $paginator->fetch($api, $method, $parameters));
    }
}
