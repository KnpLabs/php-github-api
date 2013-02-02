<?php

namespace Github\Tests;

use Github\Client;
use Github\HttpClient\Adapter\Buzz\Listener\AuthListener;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldNotHaveToPassHttpClientToConstructor()
    {
        $client = new Client();

        $this->assertInstanceOf('Github\HttpClient\HttpClientInterface', $client->getHttpClient());
    }

    /**
     * @test
     */
    public function shouldPassHttpClientInterfaceToConstructor()
    {
        $httpClient = $this->getHttpClientMock();
        $client = new Client($httpClient);

        $this->assertEquals($httpClient, $client->getHttpClient());
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldThrowExceptionWhenAuthenticatingWithoutMethodSet()
    {
        $httpClient = $this->getHttpClientMock(array('addListener'));

        $client = new Client($httpClient);
        $client->authenticate('login', null, null);
    }

    /**
     * @test
     */
    public function shouldClearHeadersLazy()
    {
        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())->method('clearHeaders');

        $client = new Client($httpClient);
        $client->clearHeaders();
    }

    /**
     * @test
     */
    public function shouldSetHeadersLaizly()
    {
        $headers = array('header1', 'header2');

        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())->method('setHeaders')->with($headers);

        $client = new Client($httpClient);
        $client->setHeaders($headers);
    }

    /**
     * @test
     * @dataProvider getApiClassesProvider
     */
    public function shouldGetApiInstance($apiName, $class)
    {
        $client = new Client();

        $this->assertInstanceOf($class, $client->api($apiName));
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldNotGetApiInstance()
    {
        $client = new Client();
        $client->api('do_not_exist');
    }

    public function getApiClassesProvider()
    {
        return array(
            array('user', 'Github\Api\User'),
            array('users', 'Github\Api\User'),

            array('me', 'Github\Api\CurrentUser'),
            array('current_user', 'Github\Api\CurrentUser'),

            array('git', 'Github\Api\GitData'),
            array('git_data', 'Github\Api\GitData'),

            array('gist', 'Github\Api\Gists'),
            array('gists', 'Github\Api\Gists'),

            array('issue', 'Github\Api\Issue'),
            array('issues', 'Github\Api\Issue'),

            array('markdown', 'Github\Api\Markdown'),

            array('organization', 'Github\Api\Organization'),
            array('organizations', 'Github\Api\Organization'),

            array('repo', 'Github\Api\Repo'),
            array('repos', 'Github\Api\Repo'),
            array('repository', 'Github\Api\Repo'),
            array('repositories', 'Github\Api\Repo'),

            array('pr', 'Github\Api\PullRequest'),
            array('pull_request', 'Github\Api\PullRequest'),
            array('pull_requests', 'Github\Api\PullRequest'),
        );
    }

    public function getHttpClientMock(array $methods = array())
    {
        $methods = array_merge(
            array(
                'get', 'post', 'patch', 'put', 'delete', 'request',
                'setOption', 'setHeaders', 'clearHeaders', 'authenticate',
                'getLastRequest', 'getLastResponse', 'getAPILimit', 'getAPIRemaining'
            ),
            $methods
        );

        return $this->getMock('Github\HttpClient\HttpClientInterface', $methods);
    }
}
