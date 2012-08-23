<?php

namespace Github\Tests;

use Github\Client;
use Github\Tests\Mock\TestHttpClient;

/**
 * Client unit test
 *
 * @author Leszek Prabucki <leszek.prabucki@gmail.com>
 */
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
    public function shouldBeAbleToPassHttpClientToConstructor()
    {
        $httpClient = $this->getHttpClientMock();
        $client = new Client($httpClient);

        $this->assertEquals($httpClient, $client->getHttpClient());
    }

    /**
     * @test
     */
    public function shouldAuthenticateUsingLoginAndPassword()
    {
        $login = 'login';
        $secret = 'password';
        $method = Client::AUTH_HTTP_PASSWORD;

        $httpClient = new TestHttpClient();

        $client = new Client($httpClient);
        $client->authenticate($login, $secret, $method);

        $expectedOptions = array(
            'login' => $login,
            'password' => $secret,
            'auth_method' => $method
        );

        $this->assertEquals($expectedOptions, $httpClient->options);
        $this->assertTrue($httpClient->authenticated);
    }

    /**
     * @test
     */
    public function shouldAuthenticateUsingHttpToken()
    {
        $login = 'login';
        $secret = 'password';
        $method = Client::AUTH_HTTP_TOKEN;

        $httpClient = new TestHttpClient();

        $client = new Client($httpClient);
        $client->authenticate($login, $secret, $method);

        $expectedOptions = array(
            'token' => $secret,
            'auth_method' => $method
        );

        $this->assertEquals($expectedOptions, $httpClient->options);
        $this->assertTrue($httpClient->authenticated);
    }

    /**
     * @test
     */
    public function shouldAuthenticateUsingUrlToken()
    {
        $login = 'login';
        $secret = 'password';
        $method = Client::AUTH_HTTP_TOKEN;

        $httpClient = new TestHttpClient();

        $client = new Client($httpClient);
        $client->authenticate($login, $secret, $method);

        $expectedOptions = array(
            'token' => $secret,
            'auth_method' => $method
        );

        $this->assertEquals($expectedOptions, $httpClient->options);
        $this->assertTrue($httpClient->authenticated);
    }

    /**
     * @test
     */
    public function shouldInjectHttpClientBySetter()
    {
        $httpClient = new TestHttpClient();
        $client = new Client();
        $client->setHttpClient($httpClient);

        $this->assertSame($httpClient, $client->getHttpClient());
    }

    /**
     * @test
     */
    public function shouldClearHeadersLaizly()
    {
        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())
            ->method('setHeaders')
            ->with(array());

        $client = new Client($httpClient);
        $client->clearHeaders();
        $client->getHttpClient();
    }

    /**
     * @test
     */
    public function shouldSetHeadersLaizly()
    {
        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())
            ->method('setHeaders')
            ->with(array('header1', 'header2'));

        $client = new Client($httpClient);
        $client->setHeaders(array('header1', 'header2'));
        $client->getHttpClient();
    }

    /**
     * @test
     */
    public function shouldDoGETRequest()
    {
        $path      = '/some/path';
        $parameters = array('a' => 'b');
        $options    = array('c' => 'd');

        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())
            ->method('get')
            ->with($path, $parameters, $options);

        $client = new Client($httpClient);
        $client->get($path, $parameters, $options);
    }

    /**
     * @test
     */
    public function shouldDoPOSTRequest()
    {
        $path      = '/some/path';
        $parameters = array('a' => 'b');
        $options    = array('c' => 'd');

        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())
            ->method('post')
            ->with($path, $parameters, $options);

        $client = new Client($httpClient);
        $client->post($path, $parameters, $options);
    }

    /**
     * @test
     */
    public function shouldDoPUTRequest()
    {
        $path      = '/some/path';
        $options    = array('c' => 'd');

        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())
            ->method('put')
            ->with($path, $options);

        $client = new Client($httpClient);
        $client->put($path, $options);
    }

    /**
     * @test
     */
    public function shouldDoPATCHRequest()
    {
        $path      = '/some/path';
        $parameters = array('a' => 'b');
        $options    = array('c' => 'd');

        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())
            ->method('patch')
            ->with($path, $parameters, $options);

        $client = new Client($httpClient);
        $client->patch($path, $parameters, $options);
    }

    /**
     * @test
     */
    public function shouldDoDELETERequest()
    {
        $path      = '/some/path';
        $parameters = array('a' => 'b');
        $options    = array('c' => 'd');

        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())
            ->method('delete')
            ->with($path, $parameters, $options);

        $client = new Client($httpClient);
        $client->delete($path, $parameters, $options);
    }

    /**
     * @test
     */
    public function shouldDoGETRequestForRateLimit()
    {
        $limit = 666;

        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())
            ->method('get')
            ->with('rate_limit')
            ->will($this->returnValue($limit));

        $client = new Client($httpClient);

        $this->assertEquals($limit, $client->getRateLimit());
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
            array('current_user', 'Github\Api\CurrentUser'),
            array('git_data', 'Github\Api\GitData'),
            array('gists', 'Github\Api\Gists'),
            array('issue', 'Github\Api\Issue'),
            array('markdown', 'Github\Api\Markdown'),
            array('organization', 'Github\Api\Organization'),
            array('repo', 'Github\Api\Repo'),
            array('pull_request', 'Github\Api\PullRequest'),
        );
    }

    protected function getHttpClientMock()
    {
        return $this->getMock('Github\HttpClient\HttpClientInterface');
    }
}
