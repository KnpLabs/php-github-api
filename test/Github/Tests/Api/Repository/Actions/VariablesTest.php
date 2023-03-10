<?php

namespace Github\Tests\Api\Repository\Actions;

use Github\Api\Repository\Actions\Variables;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class VariablesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetVariables()
    {
        $expectedArray = [
            ['name' => 'GH_TOKEN', 'value' => 'value', 'created_at' => 'created_at', 'updated_at' => 'updated_at'],
            ['name' => 'GIST_ID', 'value' => 'value', 'created_at' => 'created_at', 'updated_at' => 'updated_at'],
        ];

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/actions/variables')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetVariable()
    {
        $expectedArray = ['name' => 'name', 'value' => 'value', 'created_at' => 'created_at', 'updated_at' => 'updated_at'];

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/actions/variables/variableName')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('KnpLabs', 'php-github-api', 'variableName'));
    }

    /**
     * @test
     */
    public function shouldCreateVariable()
    {
        $expectedValue = 'response';

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/actions/variables')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', [
            'name' => 'name',
            'value' => 'value',
        ]));
    }

    /**
     * @test
     */
    public function shouldUpdateVariable()
    {
        $expectedValue = 'response';

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/actions/variables/variableName')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 'variableName', [
            'name' => 'name',
            'value' => 'value',
        ]));
    }

    /**
     * @test
     */
    public function shouldRemoveVariable()
    {
        $expectedValue = 'response';

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/actions/variables/variableName')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 'variableName'));
    }

    protected function getApiClass()
    {
        return Variables::class;
    }
}
