<?php

namespace Github\Tests;

use Github\Api;
use Github\Client;
use Github\Exception\BadMethodCallException;
use Github\HttpClient\Builder;
use Github\HttpClient\Plugin\Authentication;
use GuzzleHttp\Psr7\Response;
use Http\Client\HttpClient;
use Psr\Http\Message\RequestInterface;

class ClientTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function shouldNotHaveToPassHttpClientToConstructor()
    {
        $client = new Client();

        $this->assertInstanceOf(\Http\Client\HttpClient::class, $client->getHttpClient());
    }

    /**
     * @test
     */
    public function shouldPassHttpClientInterfaceToConstructor()
    {
        $httpClientMock = $this->getMockBuilder(\Http\Client\HttpClient::class)
            ->getMock();

        $client = Client::createWithHttpClient($httpClientMock);

        $this->assertInstanceOf(\Http\Client\HttpClient::class, $client->getHttpClient());
    }

    /**
     * @test
     * @dataProvider getAuthenticationFullData
     */
    public function shouldAuthenticateUsingAllGivenParameters($login, $password, $method)
    {
        $builder = $this->getMockBuilder(\Github\HttpClient\Builder::class)
            ->setMethods(['addPlugin', 'removePlugin'])
            ->disableOriginalConstructor()
            ->getMock();
        $builder->expects($this->once())
            ->method('addPlugin')
            ->with($this->equalTo(new Authentication($login, $password, $method)));
        $builder->expects($this->once())
            ->method('removePlugin')
            ->with(Authentication::class);

        $client = $this->getMockBuilder(\Github\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['getHttpClientBuilder'])
            ->getMock();
        $client->expects($this->any())
            ->method('getHttpClientBuilder')
            ->willReturn($builder);

        $client->authenticate($login, $password, $method);
    }

    public function getAuthenticationFullData()
    {
        return [
            ['login', 'password', Client::AUTH_HTTP_PASSWORD],
            ['token', null, Client::AUTH_HTTP_TOKEN],
            ['token', null, Client::AUTH_URL_TOKEN],
            ['client_id', 'client_secret', Client::AUTH_URL_CLIENT_ID],
        ];
    }

    /**
     * @test
     * @dataProvider getAuthenticationPartialData
     */
    public function shouldAuthenticateUsingGivenParameters($token, $method)
    {
        $builder = $this->getMockBuilder(\Github\HttpClient\Builder::class)
            ->setMethods(['addPlugin', 'removePlugin'])
            ->getMock();
        $builder->expects($this->once())
            ->method('addPlugin')
            ->with($this->equalTo(new Authentication($token, null, $method)));

        $builder->expects($this->once())
            ->method('removePlugin')
            ->with(Authentication::class);

        $client = $this->getMockBuilder(\Github\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['getHttpClientBuilder'])
            ->getMock();
        $client->expects($this->any())
            ->method('getHttpClientBuilder')
            ->willReturn($builder);

        $client->authenticate($token, $method);
    }

    public function getAuthenticationPartialData()
    {
        return [
            ['token', Client::AUTH_HTTP_TOKEN],
            ['token', Client::AUTH_URL_TOKEN],
        ];
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
        return [
            ['user', Api\User::class],
            ['users', Api\User::class],

            ['me', Api\CurrentUser::class],
            ['current_user', Api\CurrentUser::class],
            ['currentUser', Api\CurrentUser::class],

            ['git', Api\GitData::class],
            ['git_data', Api\GitData::class],
            ['gitData', Api\GitData::class],

            ['gist', Api\Gists::class],
            ['gists', Api\Gists::class],

            ['issue', Api\Issue::class],
            ['issues', Api\Issue::class],

            ['markdown', Api\Markdown::class],

            ['organization', Api\Organization::class],
            ['organizations', Api\Organization::class],

            ['repo', Api\Repo::class],
            ['repos', Api\Repo::class],
            ['repository', Api\Repo::class],
            ['repositories', Api\Repo::class],

            ['search', Api\Search::class],

            ['pr', Api\PullRequest::class],
            ['pullRequest', Api\PullRequest::class],
            ['pull_request', Api\PullRequest::class],
            ['pullRequests', Api\PullRequest::class],
            ['pull_requests', Api\PullRequest::class],

            ['authorization', Api\Authorizations::class],
            ['authorizations', Api\Authorizations::class],

            ['meta', Api\Meta::class],
        ];
    }

    /**
     * Make sure that the URL is correct when using enterprise.
     */
    public function testEnterpriseUrl()
    {
        $httpClientMock = $this->getMockBuilder(HttpClient::class)
            ->setMethods(['sendRequest'])
            ->getMock();

        $httpClientMock->expects($this->once())
            ->method('sendRequest')
            ->with($this->callback(function (RequestInterface $request) {
                return (string) $request->getUri() === 'https://foobar.com/api/v3/enterprise/stats/all';
            }))
            ->willReturn(new Response(200, [], '[]'));

        $httpClientBuilder = new Builder($httpClientMock);
        $client = new Client($httpClientBuilder, null, 'https://foobar.com');
        $client->enterprise()->stats()->show('all');
    }
}
