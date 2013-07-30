<?php

namespace Github\Tests;

use Github;
use Github\Client;
use Github\ResultPager;
use Github\HttpClient\HttpClientInterface;
use Github\Tests\Mock\TestResponse;

/**
 * ResultPagerTest
 *
 * @author Ramon de la Fuente <ramon@future500.nl>
 * @author Mitchel Verschoof <mitchel@future500.nl>
 */
class ResultPagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * description fetchAll
     */
    public function shouldGetAllResults()
    {
        $amountLoops  = 3;
        $content      = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
        $responseMock = new TestResponse($amountLoops, $content);

        // httpClient mock
        $httpClientMock = $this->getHttpClientMock($responseMock);
        $httpClientMock
            ->expects($this->exactly($amountLoops))
            ->method('get')
            ->will($this->returnValue($responseMock));

        $clientMock = $this->getClientMock($httpClientMock);

        // memberApi Mock
        $memberApiMock = $this->getApiMock('Github\Api\Organization\Members');
        $memberApiMock
            ->expects($this->once())
            ->method('all')
            ->will($this->returnValue(array()));

        $method     = 'all';
        $parameters = array('netwerven');

        // Run fetchAll on result paginator
        $paginator = new Github\ResultPager($clientMock);
        $result    = $paginator->fetchAll($memberApiMock, $method, $parameters);

        $this->assertEquals($amountLoops * count($content), count($result));
    }

    /**
     * @test
     *
     * description fetch
     */
    public function shouldGetSomeResults()
    {
        $pagination    = array('next' => 'http://github.com/next');
        $resultContent = 'organization test';

        $responseMock = $this->getResponseMock($pagination);
        $httpClient   = $this->getHttpClientMock($responseMock);
        $client       = $this->getClientMock($httpClient);

        $organizationApiMock = $this->getApiMock('Github\Api\Organization');

        $organizationApiMock
            ->expects($this->once())
            ->method('show')
            ->with('github')
            ->will($this->returnValue($resultContent));

        $paginator = new Github\ResultPager($client);
        $result    = $paginator->fetch($organizationApiMock, 'show', array('github'));

        $this->assertEquals($resultContent, $result);
        $this->assertEquals($pagination, $paginator->getPagination());
    }

    /**
     * @test
     *
     * description postFetch
     */
    public function postFetch()
    {
        $pagination = array(
            'first' => 'http://github.com',
            'next'  => 'http://github.com',
            'prev'  => 'http://github.com',
            'last'  => 'http://github.com'
        );

        // response mock
        $responseMock = $this->getMock('Github\HttpClient\Message\Response');
        $responseMock
            ->expects($this->any())
            ->method('getPagination')
            ->will($this->returnValue($pagination));

        $httpClient = $this->getHttpClientMock($responseMock);
        $client     = $this->getClientMock($httpClient);

        $paginator = new Github\ResultPager($client);
        $paginator->postFetch();

        $this->assertEquals($paginator->getPagination(), $pagination);
    }

    /**
     * @test
     *
     * description fetchNext
     */
    public function fetchNext()
    {
        $pagination    = array('next' => 'http://github.com/next');
        $resultContent = 'fetch test';

        $responseMock = $this->getResponseMock($pagination);
        $responseMock
            ->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue($resultContent));
        // Expected 2 times, 1 for setup and 1 for the actual test
        $responseMock
            ->expects($this->exactly(2))
            ->method('getPagination');

        $httpClient = $this->getHttpClientMock($responseMock);

        $httpClient
            ->expects($this->once())
            ->method('get')
            ->with($pagination['next'])
            ->will($this->returnValue($responseMock));

        $client = $this->getClientMock($httpClient);

        $paginator = new Github\ResultPager($client);
        $paginator->postFetch();

        $this->assertEquals($paginator->fetchNext(), $resultContent);
    }

    /**
     * @test
     *
     * description hasNext
     */
    public function shouldHaveNext()
    {
        $responseMock = $this->getResponseMock(array('next'  => 'http://github.com/next'));
        $httpClient   = $this->getHttpClientMock($responseMock);
        $client       = $this->getClientMock($httpClient);

        $paginator = new Github\ResultPager($client);
        $paginator->postFetch();

        $this->assertEquals($paginator->hasNext(), true);
        $this->assertEquals($paginator->hasPrevious(), false);
    }

    /**
     * @test
     *
     * description hasPrevious
     */
    public function shouldHavePrevious()
    {
        $responseMock = $this->getResponseMock(array('prev'  => 'http://github.com/previous'));
        $httpClient   = $this->getHttpClientMock($responseMock);
        $client       = $this->getClientMock($httpClient);

        $paginator = new Github\ResultPager($client);
        $paginator->postFetch();

        $this->assertEquals($paginator->hasPrevious(), true);
        $this->assertEquals($paginator->hasNext(), false);
    }

    protected function getResponseMock(array $pagination)
    {
        // response mock
        $responseMock = $this->getMock('Github\HttpClient\Message\Response');
        $responseMock
            ->expects($this->any())
            ->method('getPagination')
            ->will($this->returnValue($pagination));

        return $responseMock;
    }

    protected function getClientMock(HttpClientInterface $httpClient = null)
    {
        // if no httpClient isset use the default HttpClient mock
        if (!$httpClient) {
            $httpClient = $this->getHttpClientMock();
        }

        $client = new \Github\Client($httpClient);
        $client->setHttpClient($httpClient);

        return $client;
    }

    protected function getHttpClientMock($responseMock = null)
    {
        // mock the client interface
        $clientInterfaceMock = $this->getMock('Buzz\Client\ClientInterface', array('setTimeout', 'setVerifyPeer', 'send'));
        $clientInterfaceMock
            ->expects($this->any())
            ->method('setTimeout')
            ->with(10);
        $clientInterfaceMock
            ->expects($this->any())
            ->method('setVerifyPeer')
            ->with(false);
        $clientInterfaceMock
            ->expects($this->any())
            ->method('send');

        // create the httpClient mock
        $httpClientMock = $this->getMock('Github\HttpClient\HttpClient', array(), array(array(), $clientInterfaceMock));

        if ($responseMock) {
            $httpClientMock
                ->expects($this->any())
                ->method('getLastResponse')
                ->will($this->returnValue($responseMock));
        }

        return $httpClientMock;
    }

    protected function getApiMock($apiClass)
    {
        $client = $this->getClientMock();

        return $this->getMockBuilder($apiClass)
            ->setConstructorArgs(array($client))
            ->getMock();
    }
}
