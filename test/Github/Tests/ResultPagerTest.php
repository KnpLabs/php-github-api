<?php

namespace Github\Tests;

use Github\Api\Issue;
use Github\Api\Organization\Members;
use Github\Api\Repo;
use Github\Api\Repository\Statuses;
use Github\Api\Search;
use Github\Api\User;
use Github\Client;
use Github\ResultPager;
use Github\Tests\Mock\PaginatedResponse;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use Http\Client\HttpClient;
use Psr\Http\Client\ClientInterface;
use Symfony\Bridge\PhpUnit\ExpectDeprecationTrait;

/**
 * @author Ramon de la Fuente <ramon@future500.nl>
 * @author Mitchel Verschoof <mitchel@future500.nl>
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class ResultPagerTest extends \PHPUnit\Framework\TestCase
{
    use ExpectDeprecationTrait;

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
            ->onlyMethods(['sendRequest'])
            ->getMock();
        $httpClientMock
            ->expects($this->exactly($amountLoops))
            ->method('sendRequest')
            ->will($this->returnValue($response));

        $client = Client::createWithHttpClient($httpClientMock);

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
            ->onlyMethods(['sendRequest'])
            ->getMock();
        $httpClientMock
            ->expects($this->exactly($amountLoops))
            ->method('sendRequest')
            ->willReturn($response);

        $client = Client::createWithHttpClient($httpClientMock);

        $searchApi = new Search($client);
        $method = 'users';
        $paginator = new ResultPager($client);
        $result = $paginator->fetchAll($searchApi, $method, ['knplabs']);

        $this->assertCount($amountLoops * count($content['items']), $result);
    }

    /**
     * @test
     */
    public function shouldHandleEmptyContributorListWith204Header()
    {
        // Set up a 204 response with an empty body
        $response = new Response(204, [], '');
        $username = 'testuser';
        $reponame = 'testrepo';

        // Mock the HttpClient to return the empty response
        $httpClientMock = $this->getMockBuilder(HttpClient::class)
            ->onlyMethods(['sendRequest'])
            ->getMock();
        $httpClientMock
            ->method('sendRequest')
            ->willReturn($response);

        $client = Client::createWithHttpClient($httpClientMock);

        $repoApi = new Repo($client);

        $paginator = $this->getMockBuilder(ResultPager::class)
            ->setConstructorArgs([$client]) // Pass the Client in the constructor
            ->onlyMethods(['fetchAll'])
            ->getMock();
        $paginator->expects($this->once())
            ->method('fetchAll')
            ->with($repoApi, 'contributors', [$username, $reponame])
            ->willReturn([]);

        $this->assertEquals([], $paginator->fetchAll($repoApi, 'contributors', [$username, $reponame]));
    }

    public function testFetch()
    {
        $result = ['foo'];
        $method = 'all';
        $parameters = ['baz'];
        $api = $this->getMockBuilder(Members::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['all'])
            ->getMock();
        $api->expects($this->once())
            ->method('all')
            ->with(...$parameters)
            ->willReturn($result);

        $paginator = $this->getMockBuilder(ResultPager::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['postFetch'])
            ->getMock();

        $paginator->expects($this->once())
            ->method('postFetch');

        $this->assertEquals($result, $paginator->fetch($api, $method, $parameters));
    }

    public function testEmptyFetch()
    {
        $parameters = ['username'];
        $api = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['events'])
            ->getMock();
        $api->expects($this->once())
            ->method('events')
            ->with(...$parameters)
            ->willReturn('');

        $paginator = $this->getMockBuilder(ResultPager::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['postFetch'])
            ->getMock();

        $paginator->expects($this->once())
            ->method('postFetch');

        $this->assertEquals([], $paginator->fetch($api, 'events', $parameters));
    }

    public function testFetchAllPreserveKeys()
    {
        $content = [
            'state' => 'success',
            'statuses' => [
                ['description' => 'status 1', 'state' => 'success'],
                ['description' => 'status 2', 'state' => 'failure'],
            ],
            'sha' => '43068834af7e501778708ed13106de95f782328c',
        ];

        $response = new Response(200, ['Content-Type' => 'application/json'], Utils::streamFor(json_encode($content)));

        // httpClient mock
        $httpClientMock = $this->getMockBuilder(HttpClient::class)
            ->onlyMethods(['sendRequest'])
            ->getMock();
        $httpClientMock
            ->method('sendRequest')
            ->willReturn($response);

        $client = Client::createWithHttpClient($httpClientMock);

        $api = new Statuses($client);
        $paginator = new ResultPager($client);
        $result = $paginator->fetchAll($api, 'combined', ['knplabs', 'php-github-api', '43068834af7e501778708ed13106de95f782328c']);

        $this->assertArrayHasKey('state', $result);
        $this->assertArrayHasKey('statuses', $result);
        $this->assertCount(2, $result['statuses']);
    }

    public function testFetchAllWithoutKeys()
    {
        $content = [
            ['title' => 'issue 1'],
            ['title' => 'issue 2'],
            ['title' => 'issue 3'],
        ];

        $response = new PaginatedResponse(3, $content);

        // httpClient mock
        $httpClientMock = $this->getMockBuilder(HttpClient::class)
            ->onlyMethods(['sendRequest'])
            ->getMock();
        $httpClientMock
            ->expects($this->exactly(3))
            ->method('sendRequest')
            ->willReturn($response);

        $client = Client::createWithHttpClient($httpClientMock);

        $api = new Issue($client);
        $paginator = new ResultPager($client);
        $result = $paginator->fetchAll($api, 'all', ['knplabs', 'php-github-api']);

        $this->assertCount(9, $result);
    }

    public function testFetchAll()
    {
        $content = [
            ['title' => 'issue 1'],
            ['title' => 'issue 2'],
            ['title' => 'issue 3'],
        ];

        $response = new PaginatedResponse(3, $content);

        // httpClient mock
        $httpClientMock = $this->getMockBuilder(HttpClient::class)
            ->onlyMethods(['sendRequest'])
            ->getMock();
        $httpClientMock
            ->expects($this->exactly(3))
            ->method('sendRequest')
            ->willReturn($response);

        $client = Client::createWithHttpClient($httpClientMock);

        $api = new Issue($client);
        $paginator = new ResultPager($client);
        $result = $paginator->fetchAll($api, 'all', ['knplabs', 'php-github-api']);

        $this->assertCount(9, $result);
    }

    /**
     * @group legacy
     */
    public function testPostFetchDeprecation()
    {
        $this->expectDeprecation('Since KnpLabs/php-github-api 3.2: The "Github\ResultPager::postFetch" method is deprecated and will be removed.');

        $clientMock = $this->createMock(Client::class);
        $clientMock->method('getLastResponse')->willReturn(new PaginatedResponse(3, []));

        $paginator = new ResultPager($clientMock);
        $paginator->postFetch();
    }
}
