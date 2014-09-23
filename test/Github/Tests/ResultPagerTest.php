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
        $pagination     = array('next' => 'http://github.com/next');
        $resultContent  = 'organization test';

        $responseMock = $this->getResponseMock('<http://github.com/next>; rel="next"');
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
        $header = <<<TEXT
<http://github.com>; rel="first",
<http://github.com>; rel="next",
<http://github.com>; rel="prev",
<http://github.com>; rel="last",
TEXT;

        $pagination = array(
            'first' => 'http://github.com',
            'next'  => 'http://github.com',
            'prev'  => 'http://github.com',
            'last'  => 'http://github.com'
        );

        // response mock
        $responseMock = $this->getMock('Guzzle\Http\Message\Response', array(), array(200));
        $responseMock
            ->expects($this->any())
            ->method('getHeader')
            ->with('Link')
            ->will($this->returnValue($header));

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
        $header        = '<http://github.com/next>; rel="next"';
        $pagination    = array('next' => 'http://github.com/next');
        $resultContent = 'fetch test';

        $responseMock = $this->getResponseMock($header);
        $responseMock
            ->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($resultContent));
        // Expected 2 times, 1 for setup and 1 for the actual test
        $responseMock
            ->expects($this->exactly(2))
            ->method('getHeader')
            ->with('Link');

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
        $responseMock = $this->getResponseMock('<http://github.com/next>; rel="next"');
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
        $responseMock = $this->getResponseMock('<http://github.com/previous>; rel="prev"');
        $httpClient   = $this->getHttpClientMock($responseMock);
        $client       = $this->getClientMock($httpClient);

        $paginator = new Github\ResultPager($client);
        $paginator->postFetch();

        $this->assertEquals($paginator->hasPrevious(), true);
        $this->assertEquals($paginator->hasNext(), false);
    }

    protected function getResponseMock($header)
    {
        // response mock
        $responseMock = $this->getMock('Guzzle\Http\Message\Response', array(), array(200));
        $responseMock
            ->expects($this->any())
            ->method('getHeader')
            ->with('Link')
            ->will($this->returnValue($header));

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
        $clientInterfaceMock = $this->getMock('Guzzle\Http\Client', array('send'));
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
