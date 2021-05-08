<?php

namespace Github\Tests\Api\Repository\Actions;

use Github\Api\Repository\Actions\Secrets;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class SecretsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetSecrets()
    {
        $expectedArray = [
            ['name' => 'GH_TOKEN', 'created_at' => 'created_at', 'updated_at' => 'updated_at'],
            ['name' => 'GIST_ID', 'created_at' => 'created_at', 'updated_at' => 'updated_at'],
        ];

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/actions/secrets')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetSecret()
    {
        $expectedArray = ['name' => 'name', 'created_at' => 'created_at', 'updated_at' => 'updated_at'];

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/actions/secrets/secretName')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('KnpLabs', 'php-github-api', 'secretName'));
    }

    /**
     * @test
     */
    public function shouldCreateSecret()
    {
        $expectedValue = 'response';

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/actions/secrets/secretName')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', 'secretName', [
            'encrypted_value' => 'encryptedValue',
        ]));
    }

    /**
     * @test
     */
    public function shouldUpdateSecret()
    {
        $expectedValue = 'response';

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/actions/secrets/secretName')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 'secretName', [
            'key_id' => 'keyId', 'encrypted_value' => 'encryptedValue',
        ]));
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
            ->with('/repos/KnpLabs/php-github-api/actions/secrets/secretName')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 'secretName'));
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
            ->with('/repos/KnpLabs/php-github-api/actions/secrets/public-key')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->publicKey('KnpLabs', 'php-github-api'));
    }

    protected function getApiClass()
    {
        return Secrets::class;
    }
}
