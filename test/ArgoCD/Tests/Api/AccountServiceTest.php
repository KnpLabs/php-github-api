<?php
namespace ArgoCD\Tests\Api;

use ArgoCD\Api\AccountService;

class AccountServiceTest extends TestCase
{
    protected function getApiClass(): string
    {
        return AccountService::class;
    }

    public function testListAccounts(): void
    {
        $expectedArray = [
            ['name' => 'admin', 'enabled' => true],
            ['name' => 'user1', 'enabled' => false],
        ];

        /** @var AccountService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with($this->equalTo('/api/v1/account'))
            ->will($this->returnValue($expectedArray));

        $result = $api->listAccounts();
        self::assertIsArray($result);
        self::assertEquals($expectedArray, $result);
    }

    public function testCanIReturnsYesString(): void
    {
        /** @var AccountService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with($this->equalTo('/api/v1/account/can-i/apps/create/my-app'))
            ->will($this->returnValue('yes')); // Mock the raw string response

        $result = $api->canI('apps', 'create', 'my-app');
        self::assertIsArray($result);
        self::assertEquals(['value' => 'yes'], $result);
    }

    public function testCanIReturnsNoString(): void
    {
        /** @var AccountService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with($this->equalTo('/api/v1/account/can-i/apps/delete/my-app'))
            ->will($this->returnValue('no')); // Mock the raw string response

        $result = $api->canI('apps', 'delete', 'my-app');
        self::assertIsArray($result);
        self::assertEquals(['value' => 'no'], $result);
    }
    
    public function testCanIReturnsJson(): void
    {
        $expectedResponse = ['value' => 'yes'];
        /** @var AccountService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with($this->equalTo('/api/v1/account/can-i/apps/get/my-app'))
            ->will($this->returnValue($expectedResponse)); // Mock the array response

        $result = $api->canI('apps', 'get', 'my-app');
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    public function testUpdatePassword(): void
    {
        $expectedResponse = []; // Often empty response
        $accountName = 'admin';
        $currentPassword = 'oldPassword';
        $newPassword = 'newPassword';

        $expectedBody = [
            'name' => $accountName,
            'currentPassword' => $currentPassword,
            'newPassword' => $newPassword,
        ];

        /** @var AccountService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with(
                $this->equalTo('/api/v1/account/password'),
                $this->equalTo($expectedBody)
            )
            ->will($this->returnValue($expectedResponse));

        $result = $api->updatePassword($accountName, $currentPassword, $newPassword);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    public function testGetAccount(): void
    {
        $accountName = 'test-user';
        $expectedAccount = ['name' => $accountName, 'enabled' => true, 'capabilities' => ['login']];

        /** @var AccountService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with($this->equalTo(sprintf('/api/v1/account/%s', rawurlencode($accountName))))
            ->will($this->returnValue($expectedAccount));

        $result = $api->getAccount($accountName);
        self::assertIsArray($result);
        self::assertEquals($expectedAccount, $result);
    }

    public function testCreateToken(): void
    {
        $accountName = 'test-user';
        $tokenId = 'new-token-id';
        $tokenNameOrDescription = 'My Test Token';
        $expiresIn = '24h';

        $expectedRequestBody = [
            'id' => $tokenId,
            'name' => $tokenNameOrDescription,
            'expiresIn' => $expiresIn,
        ];
        $expectedResponseArray = [
            'token' => 'generated-jwt-string-here',
            'id' => $tokenId,
            'name' => $tokenNameOrDescription,
            'expiresIn' => $expiresIn,
            // other fields like 'issuedAt', 'expiresAt' might be present
        ];

        /** @var AccountService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo(sprintf('/api/v1/account/%s/token', rawurlencode($accountName))),
                $this->equalTo($expectedRequestBody)
            )
            ->will($this->returnValue($expectedResponseArray));

        $result = $api->createToken($accountName, $tokenId, $tokenNameOrDescription, $expiresIn);
        self::assertIsArray($result);
        self::assertEquals($expectedResponseArray, $result);
    }
    
    public function testCreateTokenWithDefaultExpiry(): void
    {
        $accountName = 'test-user-default-expiry';
        $tokenId = 'default-exp-token';
        $tokenNameOrDescription = 'Token with default expiry';
        // expiresIn is omitted, should default to "0" in the service method

        $expectedRequestBody = [
            'id' => $tokenId,
            'name' => $tokenNameOrDescription,
            'expiresIn' => "0", // Default value
        ];
        $expectedResponseArray = [
            'token' => 'another-jwt-string',
            'id' => $tokenId,
            'name' => $tokenNameOrDescription,
            'expiresIn' => "0",
        ];

        /** @var AccountService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo(sprintf('/api/v1/account/%s/token', rawurlencode($accountName))),
                $this->equalTo($expectedRequestBody)
            )
            ->will($this->returnValue($expectedResponseArray));

        // Call without the expiresIn parameter
        $result = $api->createToken($accountName, $tokenId, $tokenNameOrDescription);
        self::assertIsArray($result);
        self::assertEquals($expectedResponseArray, $result);
    }

    public function testDeleteToken(): void
    {
        $expectedResponse = []; // Often empty response
        $accountName = 'test-user';
        $tokenId = 'token-to-delete';

        /** @var AccountService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with($this->equalTo(sprintf('/api/v1/account/%s/token/%s', rawurlencode($accountName), rawurlencode($tokenId))))
            ->will($this->returnValue($expectedResponse));

        $result = $api->deleteToken($accountName, $tokenId);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }
}
