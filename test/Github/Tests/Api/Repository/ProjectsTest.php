<?php

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class ProjectsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllRepositoryProjects()
    {
        $expectedValue = array(array('name' => 'Test project 1'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/projects')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldShowProject()
    {
        $expectedValue = array('name' => 'Test project 1');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/projects/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateWithoutName()
    {
        $data = array();

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldCreateColumn()
    {
        $expectedValue = array('column1data');
        $data = array('name' => 'Project 1');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/projects', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldUpdateProject()
    {
        $expectedValue = array('project1data');
        $data = array('name' => 'Project 1 update');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/projects/123', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 123, $data));
    }

    /**
     * @test
     */
    public function shouldRemoveProject()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/projects/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->deleteProject('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     */
    public function shouldGetColumnsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Repository\Columns', $api->columns());
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Repository\Projects::class;
    }
}
