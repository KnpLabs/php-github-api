<?php

namespace Github\Tests;

use Github\Api;
use Github\Client;
use Github\Exception\BadMethodCallException;
use Github\HttpClient\Builder;
use Github\HttpClient\Plugin\Authentication;
use GuzzleHttp\Psr7\Response;
use Http\Client\Common\Plugin;
use Http\Client\HttpClient;
use Psr\Http\Message\RequestInterface;

class ClientTest extends \PHPUnit_Framework_TestCase
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
            ->setMethods(array('addPlugin', 'removePlugin'))
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
        $builder = $this->getMockBuilder(\Github\HttpClient\Builder::class)
            ->setMethods(array('addPlugin', 'removePlugin'))
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
            array('user', Api\User::class),
            array('users', Api\User::class),

            array('me', Api\CurrentUser::class),
            array('current_user', Api\CurrentUser::class),
            array('currentUser', Api\CurrentUser::class),

            array('git', Api\GitData::class),
            array('git_data', Api\GitData::class),
            array('gitData', Api\GitData::class),

            array('gist', Api\Gists::class),
            array('gists', Api\Gists::class),

            array('issue', Api\Issue::class),
            array('issues', Api\Issue::class),

            array('markdown', Api\Markdown::class),

            array('organization', Api\Organization::class),
            array('organizations', Api\Organization::class),

            array('repo', Api\Repo::class),
            array('repos', Api\Repo::class),
            array('repository', Api\Repo::class),
            array('repositories', Api\Repo::class),

            array('search', Api\Search::class),

            array('pr', Api\PullRequest::class),
            array('pullRequest', Api\PullRequest::class),
            array('pull_request', Api\PullRequest::class),
            array('pullRequests', Api\PullRequest::class),
            array('pull_requests', Api\PullRequest::class),

            array('authorization', Api\Authorizations::class),
            array('authorizations', Api\Authorizations::class),

            array('meta', Api\Meta::class)
        );
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
