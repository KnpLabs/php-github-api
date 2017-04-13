<?php

namespace Github\Tests\Api\Issue;

use Github\Tests\Api\TestCase;

class LabelsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetProjectLabels()
    {
        $expectedValue = array(
            array('name' => 'l3l0repo'),
            array('name' => 'other'),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/labels', array())
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetAllIssueLabels()
    {
        $expectedValue = array(array('name' => 'label'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/issues/123/labels')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', '123'));
    }

    /**
     * @test
     */
    public function shouldCreateLabel()
    {
        $expectedValue = array(array('name' => 'label', 'color' => 'FFFFFF'));
        $data = array('name' => 'label');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/labels', $data + array('color' => 'FFFFFF'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldGetSingleLabel()
    {
        $expectedValue = array(array('name' => 'label1'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/labels/label1')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 'label1'));
    }

    /**
     * @test
     */
    public function shouldCreateLabelWithColor()
    {
        $expectedValue = array(array('name' => 'label', 'color' => '111111'));
        $data = array('name' => 'label', 'color' => '111111');

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
    public function shouldDeleteLabel()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/labels/foo')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->deleteLabel('KnpLabs', 'php-github-api', 'foo'));
    }

    /**
     * @test
     */
    public function shouldUpdateLabel()
    {
        $expectedValue = array(array('name' => 'bar', 'color' => 'FFF'));
        $data = array('name' => 'bar', 'color' => 'FFF');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/labels/foo', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 'foo', 'bar', 'FFF'));
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
            ->with('/repos/KnpLabs/php-github-api/issues/123/labels/somename')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 123, 'somename'));
    }

    /**
     * @test
     */
    public function shouldAddOneLabel()
    {
        $expectedValue = array('label' => 'somename');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/issues/123/labels', array('labelname'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->add('KnpLabs', 'php-github-api', 123, 'labelname'));
    }

    /**
     * @test
     */
    public function shouldAddManyLabels()
    {
        $expectedValue = array('label' => 'somename');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/issues/123/labels', array('labelname', 'labelname2'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->add('KnpLabs', 'php-github-api', 123, array('labelname', 'labelname2')));
    }

    /**
     * @test
     */
    public function shouldReplaceLabels()
    {
        $expectedValue = array(array('label' => 'somename'));
        $data = array('labels' => array('labelname'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/issues/123/labels', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->replace('KnpLabs', 'php-github-api', 123, $data));
    }

    /**
     * @test
     * @expectedException \Github\Exception\InvalidArgumentException
     */
    public function shouldNotAddWhenDoNotHaveLabelsToAdd()
    {
        $api = $this->getApiMock();
        $api->expects($this->any())
            ->method('post');

        $api->add('KnpLabs', 'php-github-api', 123, array());
    }

    /**
     * @test
     */
    public function shouldClearLabels()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/issues/123/labels')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->clear('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Issue\Labels::class;
    }
}
