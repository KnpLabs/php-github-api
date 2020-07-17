<?php

namespace Github\Tests\Api\Repository;

use Github\Exception\MissingArgumentException;
use Github\Tests\Api\TestCase;

class LabelsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllRepositoryLabelss()
    {
        $expectedValue = [['name' => 'label']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/labels')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldShowLabel()
    {
        $expectedValue = ['label' => 'somename'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/labels/somename')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 'somename'));
    }

    /**
     * @test
     */
    public function shouldRemoveLabel()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/labels/somename')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 'somename'));
    }

    /**
     * @test
     */
    public function shouldNotCreateLabelWithoutName()
    {
        $this->expectException(MissingArgumentException::class);
        $data = ['color' => 'red'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldNotCreateLabelWithoutColor()
    {
        $this->expectException(MissingArgumentException::class);
        $data = ['name' => 'test'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldCreateLabel()
    {
        $expectedValue = ['label' => 'somename'];
        $data = ['name' => 'test', 'color' => 'red'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/labels', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldUpdateLabel()
    {
        $expectedValue = ['name' => 'test'];
        $data = ['new_name' => 'test', 'color' => 'red'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/labels/labelName', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 'labelName', $data));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Repository\Labels::class;
    }
}
