<?php

namespace Github\Tests\Api\Environment;

use Github\Api\Environment\Variables;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class VariablesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetEnvironmentVariables()
    {
        $expectedArray = [
            ['name' => 'name', 'value' => 'value', 'created_at' => 'created_at', 'updated_at' => 'updated_at'],
            ['name' => 'name', 'value' => 'value', 'created_at' => 'created_at', 'updated_at' => 'updated_at'],
            ['name' => 'name', 'value' => 'value', 'created_at' => 'created_at', 'updated_at' => 'updated_at'],
        ];

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repositories/3948501/environments/production/variables')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all(3948501, 'production'));
    }

    /**
     * @test
     */
    public function shouldGetEnvironmentVariable()
    {
        $expectedArray = [];

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repositories/3948501/environments/production/variables/variableName')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show(3948501, 'production', 'variableName'));
    }

    /**
     * @test
     */
    public function shouldCreateEnvironmentVariable()
    {
        $expectedValue = 'response';

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('post')
            ->with('/repositories/3948501/environments/production/variables')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create(3948501, 'production', [
            'name' => 'foo', 'value' => 'bar',
        ]));
    }

    /**
     * @test
     */
    public function shouldUpdateEnvironmentVariable()
    {
        $expectedValue = 'response';

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('patch')
            ->with('/repositories/3948501/environments/production/variables/variableName')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update(3948501, 'production', 'variableName', [
            'name' => 'variableName', 'value' => 'bar',
        ]));
    }

    /**
     * @test
     */
    public function shouldRemoveEnvironmentVariable()
    {
        $expectedValue = 'response';

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('delete')
            ->with('/repositories/3948501/environments/production/variables/variableName')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove(3948501, 'production', 'variableName'));
    }

    protected function getApiClass()
    {
        return Variables::class;
    }
}
