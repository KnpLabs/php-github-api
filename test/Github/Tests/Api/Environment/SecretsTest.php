<?php

namespace Github\Tests\Api\Environment;

use Github\Api\Environment\Secrets;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class SecretsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetEnvironmentSecrets()
    {
        $expectedArray = [
            ['name' => 'name', 'created_at' => 'created_at', 'updated_at' => 'updated_at'],
            ['name' => 'name', 'created_at' => 'created_at', 'updated_at' => 'updated_at'],
            ['name' => 'name', 'created_at' => 'created_at', 'updated_at' => 'updated_at'],
        ];

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repositories/3948501/environments/production/secrets')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all(3948501, 'production'));
    }

    /**
     * @test
     */
    public function shouldGetEnvironmentSecret()
    {
        $expectedArray = [];

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repositories/3948501/environments/production/secrets/secretName')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show(3948501, 'production', 'secretName'));
    }

    /**
     * @test
     */
    public function shouldUpdateOrCreateEnvironmentSecret()
    {
        $expectedValue = 'response';

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('put')
            ->with('/repositories/3948501/environments/production/secrets/secretName')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->createOrUpdate(3948501, 'production', 'secretName', [
            'encrypted_value' => 'foo', 'key_id' => 'key_id',
        ]));
    }

    /**
     * @test
     */
    public function shouldRemoveEnvironmentSecret()
    {
        $expectedValue = 'response';

        /** @var Secrets|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('delete')
            ->with('/repositories/3948501/environments/production/secrets/secretName')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove(3948501, 'production', 'secretName'));
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
            ->with('/repositories/3948501/environments/production/secrets/public-key')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->publicKey(3948501, 'production'));
    }

    protected function getApiClass()
    {
        return Secrets::class;
    }
}
