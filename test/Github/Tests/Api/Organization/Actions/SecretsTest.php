<?php

namespace Github\Tests\Api\Organization\Actions;

use Github\Api\Organization\Actions\Secrets;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class SecretsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetOrganizationSecrets()
    {
        $expectedArray = [
            ['name' => 'name', 'created_at' => 'created_at', 'updated_at' => 'updated_at', 'visibility' => 'all'],
            ['name' => 'name', 'created_at' => 'created_at', 'updated_at' => 'updated_at', 'visibility' => 'private'],
            ['name' => 'name', 'created_at' => 'created_at', 'updated_at' => 'updated_at', 'visibility' => 'selected'],
        ];

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/actions/secrets')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldGetOrganizationSecret()
    {
        $expectedArray = [];

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/actions/secrets/secretName')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('KnpLabs', 'secretName'));
    }

    /**
     * @test
     */
    public function shouldCreateOrganizationSecret()
    {
        $expectedValue = 'response';

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('put')
            ->with('/orgs/KnpLabs/actions/secrets/secretName')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'secretName', [
            'encrypted_value' => 'foo', 'visibility' => 'all', 'selected_repository_ids' => [1, 2, 3],
        ]));
    }

    /**
     * @test
     */
    public function shouldUpdateOrganizationSecret()
    {
        $expectedValue = 'response';

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('put')
            ->with('/orgs/KnpLabs/actions/secrets/secretName')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'secretName', [
            'key_id' => 'keyId',
            'encrypted_value' => 'encryptedValue',
            'visibility' => 'private',
        ]));
    }

    /**
     * @test
     */
    public function shouldRemoveOrganizationSecret()
    {
        $expectedValue = 'response';

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('delete')
            ->with('/orgs/KnpLabs/actions/secrets/secretName')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'secretName'));
    }

    /**
     * @test
     */
    public function shouldGetSelectedRepositories()
    {
        $expectedArray = [1, 2, 3];

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/actions/secrets/secretName/repositories')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->selectedRepositories('KnpLabs', 'secretName'));
    }

    /**
     * @test
     */
    public function shouldSetSelectedRepositories()
    {
        $expectedArray = [
            'selected_repository_ids' => [1, 2, 3],
        ];

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('put')
            ->with('/orgs/KnpLabs/actions/secrets/secretName/repositories')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->setSelectedRepositories('KnpLabs', 'secretName', [
            'selected_repository_ids' => [1, 2, 3],
        ]));
    }

    /**
     * @test
     */
    public function shouldAddSecret()
    {
        $expectedValue = 'response';

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('put')
            ->with('/orgs/KnpLabs/actions/secrets/secretName/repositories/1')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->addSecret('KnpLabs', '1', 'secretName'));
    }

    /**
     * @test
     */
    public function shouldRemoveSecret()
    {
        $expectedValue = 'response';

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('delete')
            ->with('/orgs/KnpLabs/actions/secrets/secretName/repositories/1')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeSecret('KnpLabs', '1', 'secretName'));
    }

    /**
     * @test
     */
    public function shouldGetPublicKey()
    {
        $expectedArray = ['key_id' => 'key_id', 'key' => 'foo'];

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/actions/secrets/public-key')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->publicKey('KnpLabs'));
    }

    protected function getApiClass()
    {
        return Secrets::class;
    }
}
