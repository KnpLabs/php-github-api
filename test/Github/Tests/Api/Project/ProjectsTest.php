<?php declare(strict_types=1);

namespace Github\Tests\Api\Project;

use Github\Api\Project\AbstractProjectApi;
use Github\Tests\Api\TestCase;

class ProjectsTest extends TestCase
{
    public function shouldShowProject()
    {
        $expectedValue = ['name' => 'Test project 1'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/projects/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show(123));
    }

    public function shouldUpdateProject()
    {
        $expectedValue = ['project1data'];
        $data = ['name' => 'Project 1 update'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/projects/123', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update(123, $data));
    }

    public function shouldRemoveProject()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/projects/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->deleteProject(123));
    }

    public function shouldGetColumnsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Project\Columns', $api->columns());
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return AbstractProjectApi::class;
    }
}
