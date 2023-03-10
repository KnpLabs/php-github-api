<?php

namespace Github\Tests\Api\Organization\Actions;

use Github\Api\Organization\Actions\Variables;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class VariablesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetOrganizationVariables()
    {
        $expectedArray = [
            ['name' => 'name', 'value' => 'value', 'created_at' => 'created_at', 'updated_at' => 'updated_at', 'visibility' => 'all'],
            ['name' => 'name', 'value' => 'value', 'created_at' => 'created_at', 'updated_at' => 'updated_at', 'visibility' => 'private'],
            ['name' => 'name', 'value' => 'value', 'created_at' => 'created_at', 'updated_at' => 'updated_at', 'visibility' => 'selected'],
        ];

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/actions/variables')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldGetOrganizationVariable()
    {
        $expectedArray = [];

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/actions/variables/variableName')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('KnpLabs', 'variableName'));
    }

    /**
     * @test
     */
    public function shouldCreateOrganizationVariable()
    {
        $expectedValue = 'response';

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('post')
            ->with('/orgs/KnpLabs/actions/variables')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', [
            'name' => 'foo', 'value' => 'value', 'visibility' => 'all',
        ]));
    }

    /**
     * @test
     */
    public function shouldUpdateOrganizationVariable()
    {
        $expectedValue = 'response';

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('patch')
            ->with('/orgs/KnpLabs/actions/variables/variableName')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'variableName', [
            'name' => 'foo', 'value' => 'value', 'visibility' => 'private',
        ]));
    }

    /**
     * @test
     */
    public function shouldRemoveOrganizationVariable()
    {
        $expectedValue = 'response';

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('delete')
            ->with('/orgs/KnpLabs/actions/variables/variableName')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'variableName'));
    }

    /**
     * @test
     */
    public function shouldGetSelectedRepositories()
    {
        $expectedArray = [1, 2, 3];

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/actions/variables/variableName/repositories')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->selectedRepositories('KnpLabs', 'variableName'));
    }

    /**
     * @test
     */
    public function shouldSetSelectedRepositories()
    {
        $expectedArray = [
            'selected_repository_ids' => [1, 2, 3],
        ];

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('put')
            ->with('/orgs/KnpLabs/actions/variables/variableName/repositories')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->setSelectedRepositories('KnpLabs', 'variableName', [
            'selected_repository_ids' => [1, 2, 3],
        ]));
    }

    /**
     * @test
     */
    public function shouldAddRepository()
    {
        $expectedValue = 'response';

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('put')
            ->with('/orgs/KnpLabs/actions/variables/variableName/repositories/1')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->addRepository('KnpLabs', 1, 'variableName'));
    }

    /**
     * @test
     */
    public function shouldRemoveRepository()
    {
        $expectedValue = 'response';

        /** @var Variables|MockObject $api */
        $api = $this->getApiMock();

        $api
            ->expects($this->once())
            ->method('delete')
            ->with('/orgs/KnpLabs/actions/variables/variableName/repositories/1')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeRepository('KnpLabs', 1, 'variableName'));
    }

    protected function getApiClass()
    {
        return Variables::class;
    }
}
