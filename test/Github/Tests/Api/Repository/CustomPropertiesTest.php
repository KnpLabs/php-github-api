<?php

namespace Github\Tests\Api\Repository;

use Github\Api\Repository\CustomProperties;
use Github\Tests\Api\TestCase;

class CustomPropertiesTest extends TestCase
{
    public function testAll()
    {
        $expectedArray = ['property1' => 'value1', 'property2' => 'value2'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/owner/repo/properties/values')
            ->willReturn($expectedArray);

        $this->assertEquals($expectedArray, $api->all('owner', 'repo'));
    }

    public function testShowPropertyExists()
    {
        $allProperties = [
            'property1' => 'value1',
            'property2' => 'value2',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/owner/repo/properties/values')
            ->willReturn($allProperties);

        $expectedResult = [
            'property_name' => 'property2',
            'value' => 'value2'
        ];

        $this->assertEquals($expectedResult, $api->show('owner', 'repo', 'property2'));
    }

    public function testShowPropertyDoesNotExist()
    {
        $allProperties = [
            'property1' => 'value1',
            'property2' => 'value2',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/owner/repo/properties/values')
            ->willReturn($allProperties);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Property [property3] not found.');

        $api->show('owner', 'repo', 'property3');
    }

    public function testUpdate()
    {
        $params = [
            'property1' => 'newValue1',
            'property2' => 42,
        ];

        $expectedResponse = [
            'property1' => 'newValue1',
            'property2' => 42,
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/owner/repo/properties/values', $params)
            ->willReturn($expectedResponse);

        $this->assertEquals($expectedResponse, $api->update('owner', 'repo', $params));
    }

    protected function getApiClass()
    {
        return CustomProperties::class;
    }
}
