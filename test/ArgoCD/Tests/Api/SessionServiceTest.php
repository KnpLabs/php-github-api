<?php
namespace ArgoCD\Tests\Api;

use ArgoCD\Api\SessionService;

class SessionServiceTest extends TestCase
{
    protected function getApiClass(): string
    {
        return SessionService::class;
    }

    public function testCreateSession(): void
    {
        $expectedResponse = ['token' => 'mocked-jwt-token'];
        $username = 'testuser';
        $password = 'testpass';

        /** @var SessionService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('/api/v1/session'),
                $this->equalTo(['username' => $username, 'password' => $password])
            )
            ->will($this->returnValue($expectedResponse));

        $result = $api->create($username, $password);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    public function testDeleteSession(): void
    {
        // The Swagger spec indicates SessionSessionResponse, which has a 'token' field.
        // A real delete might return an empty body, but our AbstractApi::delete
        // usually decodes JSON or returns empty array if decode fails or body is empty.
        $expectedResponse = []; // Or ['token' => null] if AbstractApi guarantees field presence

        /** @var SessionService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with($this->equalTo('/api/v1/session'))
            ->will($this->returnValue($expectedResponse));

        $result = $api->delete();
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    public function testGetUserInfo(): void
    {
        $expectedResponse = [
            'loggedIn' => true,
            'username' => 'testuser',
            'iss' => 'argocd',
            'groups' => ['my-group'],
        ];

        /** @var SessionService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with($this->equalTo('/api/v1/session/userinfo'))
            ->will($this->returnValue($expectedResponse));

        $result = $api->getUserInfo();
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }
}
