<?php

namespace Github\Tests;

use Github;
use Github\Client;
use Github\ResultPager;

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
        $organizationMockApi = $this->getApiMock( 'Github\Api\Organization' );
        $method              = 'all';
        $parameters          = array('netwerven');

        // $paginator = new Github\ResultPaginator( $client );
        // $result    = $paginator->fetchAll( $organizationMockApi, 'repositories', $parameters );
    }

    /**
     * @test
     *
     * description postFetch
     */
    public function postFetch()
    {

    }

    /**
     * @test
     *
     * description fetchNext
     */
    public function fetchNext()
    {

    }

    /**
     * @test
     *
     * description hasNext
     */
    public function shouldHasNext()
    {

    }

    /**
     * @test
     *
     * description hasPrevious
     */
    public function shouldHasPrevious()
    {

    }

    /**
     * @test
     *
     * description first
     */
    public function shouldHasFirst()
    {

    }

    /**
     * @test
     *
     * description last
     */
    public function shouldHasLast()
    {

    }

    protected function getApiMock( $apiClass )
    {
        $responseStub = $this->getMock('Github\HttpClient\Message\Response', array('getPagination'));
        $responseStub
            ->expects($this->any())
            ->method('getPagination')
            ->with(array('test' => 'test'));

        var_dump( "\n" );
        var_dump( $responseStub );
        exit;

        $httpClient = $this->getMock('Buzz\Client\ClientInterface', array('setTimeout', 'setVerifyPeer', 'send', 'getLastResponse'));
        $httpClient
            ->expects($this->any())
            ->method('setTimeout')
            ->with(10);
        $httpClient
            ->expects($this->any())
            ->method('setVerifyPeer')
            ->with(false);
        $httpClient
            ->expects($this->any())
            ->method('send');
        $httpClient
            ->expects($this->any())
            ->method('getLastResponse')
            ->with(array(
                'first'    => 'test',
                'next'     => 'test',
                'previous' => 'test',
                'last'     => 'test',
            ));

        $mock = $this->getMock('Github\HttpClient\HttpClient', array(), array(array(), $httpClient));

        var_dump( $mock->getLastResponse(), $mock );

        $client = new \Github\Client($mock);
        $client->setHttpClient($mock);

        var_dump( $client->getHttpClient()->getLastResponse() );

        return $this->getMockBuilder( $apiClass )
            ->setMethods(array('get', 'post', 'patch', 'delete', 'put'))
            ->setConstructorArgs(array($client))
            ->getMock();
    }

}