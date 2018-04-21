<?php

namespace Github\Tests\Api\Repository;

use Github\Api\Repository\Invitations;
use Github\Client;
use Github\Exception\InvalidArgumentException;
use Github\Tests\Api\TestCase;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Client\HttpClient;

class InvitationTest extends TestCase
{
    /**
     * @test
     */
    public function shouldAddAnInvitationWithPullPermission()
    {
        $client = $this->getClientMock(function (Request $request) {
            $payload = json_decode($request->getBody()->getContents(), true);
            $this->assertEquals('PUT', $request->getMethod());
            $this->assertEquals('/repos/KnpLabs/php-github-api/collaborators/danielcamargo', $request->getUri()->getPath());
            $this->assertEquals(['permissions' => Invitations::PULL_PERMISSIONS], $payload);
        });

        $client->repo()->invitations()
            ->add('KnpLabs', 'php-github-api', 'danielcamargo', Invitations::PULL_PERMISSIONS);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldThrowInvalidArgumentExceptionWhenAddingWithInvalidPermissions()
    {
        $client = $this->getClientMock(function (Request $request) {
        });

        $client->repo()->invitations()
            ->add('KnpLabs', 'php-github-api', 'danielcamargo', 'foo');
    }

    /**
     * @test
     */
    public function shouldUpdateAnInvitationWithValidPermissions()
    {
        $client = $this->getClientMock(function (Request $request) {
            $payload = json_decode($request->getBody()->getContents(), true);
            $this->assertEquals('PATCH', $request->getMethod());
            $this->assertEquals('/repos/KnpLabs/php-github-api/invitations/1', $request->getUri()->getPath());
            $this->assertEquals(['permissions' => Invitations::ADMIN_PERMISSIONS], $payload);
        });

        $client->repo()->invitations()
            ->updatePermissions('KnpLabs', 'php-github-api', 1, Invitations::ADMIN_PERMISSIONS);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldFailUpdateWhenGivenInvalidPermissions()
    {
        $client = $this->getClientMock(function (Request $request) {
        });

        $client->repo()->invitations()
            ->updatePermissions('KnpLabs', 'php-github-api', 1, 'foo');
    }

    /**
     * @test
     */
    public function shouldCallListInvitationsEndpoint()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/invitations');

        /** @var Invitations $invitationsApi */
        $invitationsApi = $api;

        $invitationsApi->all('KnpLabs', 'php-github-api');
    }

    /**
     * @test
     */
    public function shouldCallAcceptInvitationsEndpoint()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/user/repository_invitations/1');

        /** @var Invitations $invitationsApi */
        $invitationsApi = $api;

        $invitationsApi->accept(1);
    }

    /**
     * @test
     */
    public function shouldCallDeclineInvitationsEndpoint()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/user/repository_invitations/1');

        /** @var Invitations $invitationsApi */
        $invitationsApi = $api;

        $invitationsApi->decline(1);
    }

    /**
     * @test
     */
    public function shouldCallDeleteInvitationsEndpoint()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/invitations/1');

        /** @var Invitations $invitationsApi */
        $invitationsApi = $api;

        $invitationsApi->remove('KnpLabs', 'php-github-api', 1);
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return Invitations::class;
    }

    /**
     * @param callable   $callback
     * @param null|array $result
     *
     * @return Client
     */
    private function getClientMock($callback, $result = null)
    {
        $response = $this->getMockBuilder(Response::class)->getMock();
        $response->expects($this->any())->method('getStatusCode')->willReturn(200);
        $response->expects($this->any())->method('getBody')
            ->willReturn(\GuzzleHttp\Psr7\stream_for($result ? json_encode($result) : ''));

        $stub = $this->getMockBuilder(HttpClient::class)->setMethods(['sendRequest'])->getMock();
        $stub->expects($this->any())->method('sendRequest')
            ->willReturnCallback(function (Request $request) use ($response, $callback) {
                if (is_callable($callback)) {
                    call_user_func($callback, $request);
                }
                return $response;
            });

        /** @var HttpClient $httpClient */
        $httpClient = $stub;
        return Client::createWithHttpClient($httpClient);
    }
}
