<?php

namespace Github\Tests;

use Github\Client;
use Github\Exception\BadMethodCallException;
use Github\HttpClient\Plugin\Authentication;
use Http\Client\Common\Plugin;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldNotHaveToPassHttpClientToConstructor()
    {
        $client = new Client();

        $this->assertInstanceOf('\Http\Client\HttpClient', $client->getHttpClient());
    }

    /**
     * @test
     */
    public function shouldPassHttpClientInterfaceToConstructor()
    {
        $httpClientMock = $this->getMockBuilder('Http\Client\HttpClient')
            ->getMock();
        $client = new Client($httpClientMock);

        $this->assertInstanceOf('Http\Client\HttpClient', $client->getHttpClient());
    }

    /**
     * @test
     * @dataProvider getAuthenticationFullData
     */
    public function shouldAuthenticateUsingAllGivenParameters($login, $password, $method)
    {
        $client = $this->getMockBuilder('Github\Client')
            ->setMethods(array('addPlugin', 'removePlugin'))
            ->getMock();
        $client->expects($this->once())
            ->method('addPlugin')
            ->with($this->equalTo(new Authentication($login, $password, $method)));

        $client->expects($this->once())
            ->method('removePlugin')
            ->with(Authentication::class);

        $client->authenticate($login, $password, $method);
    }

    public function getAuthenticationFullData()
    {
        return array(
            array('login', 'password', Client::AUTH_HTTP_PASSWORD),
            array('token', null, Client::AUTH_HTTP_TOKEN),
            array('token', null, Client::AUTH_URL_TOKEN),
            array('client_id', 'client_secret', Client::AUTH_URL_CLIENT_ID),
        );
    }

    /**
     * @test
     * @dataProvider getAuthenticationPartialData
     */
    public function shouldAuthenticateUsingGivenParameters($token, $method)
    {
        $client = $this->getMockBuilder('Github\Client')
            ->setMethods(array('addPlugin', 'removePlugin'))
            ->getMock();
        $client->expects($this->once())
            ->method('addPlugin')
            ->with($this->equalTo(new Authentication($token, null, $method)));

        $client->expects($this->once())
            ->method('removePlugin')
            ->with(Authentication::class);

        $client->authenticate($token, $method);
    }

    public function getAuthenticationPartialData()
    {
        return array(
            array('token', Client::AUTH_HTTP_TOKEN),
            array('token', Client::AUTH_URL_TOKEN),
        );
    }

    /**
     * @test
     * @expectedException \Github\Exception\InvalidArgumentException
     */
    public function shouldThrowExceptionWhenAuthenticatingWithoutMethodSet()
    {
        $client = new Client();

        $client->authenticate('login', null, null);
    }

    /**
     * @test
     */
    public function shouldClearHeaders()
    {
        $client = $this->getMockBuilder('Github\Client')
            ->setMethods(array('addPlugin', 'removePlugin'))
            ->getMock();
        $client->expects($this->once())
            ->method('addPlugin')
            ->with($this->isInstanceOf(Plugin\HeaderAppendPlugin::class));

        $client->expects($this->once())
            ->method('removePlugin')
            ->with(Plugin\HeaderAppendPlugin::class);

        $client->clearHeaders();
    }

    /**
     * @test
     */
    public function shouldAddHeaders()
    {
        $headers = array('header1', 'header2');

        $client = $this->getMockBuilder('Github\Client')
            ->setMethods(array('addPlugin', 'removePlugin'))
            ->getMock();
        $client->expects($this->once())
            ->method('addPlugin')
            // TODO verify that headers exists
            ->with($this->isInstanceOf(Plugin\HeaderAppendPlugin::class));

        $client->expects($this->once())
            ->method('removePlugin')
            ->with(Plugin\HeaderAppendPlugin::class);

        $client->addHeaders($headers);
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
     * @dataProvider getApiClassesProvider
     */
    public function shouldGetMagicApiInstance($apiName, $class)
    {
        $client = new Client();

        $this->assertInstanceOf($class, $client->$apiName());
    }

    /**
     * @test
     * @expectedException \Github\Exception\InvalidArgumentException
     */
    public function shouldNotGetApiInstance()
    {
        $client = new Client();
        $client->api('do_not_exist');
    }

    /**
     * @test
     * @expectedException BadMethodCallException
     */
    public function shouldNotGetMagicApiInstance()
    {
        $client = new Client();
        $client->doNotExist();
    }

    public function getApiClassesProvider()
    {
        return array(
            array('user', 'Github\Api\User'),
            array('users', 'Github\Api\User'),

            array('me', 'Github\Api\CurrentUser'),
            array('current_user', 'Github\Api\CurrentUser'),
            array('currentUser', 'Github\Api\CurrentUser'),

            array('git', 'Github\Api\GitData'),
            array('git_data', 'Github\Api\GitData'),
            array('gitData', 'Github\Api\GitData'),

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

            array('search', 'Github\Api\Search'),

            array('pr', 'Github\Api\PullRequest'),
            array('pullRequest', 'Github\Api\PullRequest'),
            array('pull_request', 'Github\Api\PullRequest'),
            array('pullRequests', 'Github\Api\PullRequest'),
            array('pull_requests', 'Github\Api\PullRequest'),

            array('authorization', 'Github\Api\Authorizations'),
            array('authorizations', 'Github\Api\Authorizations'),

            array('meta', 'Github\Api\Meta')
        );
    }
}
