<?php

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class LabelsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllRepositoryLabelss()
    {
        $expectedValue = array(array('name' => 'label'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/labels')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldShowLabel()
    {
        $expectedValue = array('label' => 'somename');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/labels/somename')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 'somename'));
    }

    /**
     * @test
     */
    public function shouldRemoveLabel()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('repos/KnpLabs/php-github-api/labels/somename')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 'somename'));
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateLabelWithoutName()
    {
        $data = array('color' => 'red');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateLabelWithoutColor()
    {
        $data = array('name' => 'test');

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
        $expectedValue = array('label' => 'somename');
        $data = array('name' => 'test', 'color' => 'red');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('repos/KnpLabs/php-github-api/labels', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }


    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotUpdateLabelWithoutName()
    {
        $data = array('color' => 'red');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('patch');

        $api->update('KnpLabs', 'php-github-api', 'labelName', $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotUpdateLabelWithoutColor()
    {
        $data = array('name' => 'test');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('patch');

        $api->update('KnpLabs', 'php-github-api', 'labelName', $data);
    }

    /**
     * @test
     */
    public function shouldUpdateLabel()
    {
        $expectedValue = array('label' => 'somename');
        $data = array('name' => 'test', 'color' => 'red');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('repos/KnpLabs/php-github-api/labels/labelName', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 'labelName', $data));
    }

    protected function getApiClass()
    {
        return 'Github\Api\Repository\Labels';
    }
}
