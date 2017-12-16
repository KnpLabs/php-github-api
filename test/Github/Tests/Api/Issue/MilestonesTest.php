<?php

namespace Github\Tests\Api\Issue;

use Github\Tests\Api\TestCase;

class MilestonesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetMilestones()
    {
        $expectedValue = [['name' => 'l3l0repo']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/milestones', ['page' => 1, 'state' => 'open', 'sort' => 'due_date', 'direction' => 'asc'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldCreateMilestone()
    {
        $expectedValue = [['title' => 'milestone']];
        $data = ['title' => 'milestone'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/milestones', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateMilestoneWithoutTitle()
    {
        $expectedValue = [['title' => 'milestone']];
        $data = [];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldSetStateToOpenWhileCreationWhenStateParamNotRecognized()
    {
        $expectedValue = ['title' => 'l3l0repo'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/milestones', ['state' => 'open', 'title' => 'milestone'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', ['state' => 'clos', 'title' => 'milestone']));
    }

    /**
     * @test
     */
    public function shouldUpdateMilestone()
    {
        $expectedValue = [['title' => 'milestone']];
        $data = ['title' => 'milestone'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/milestones/123', ['title' => 'milestone'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 123, $data));
    }

    /**
     * @test
     */
    public function shouldUpdateMilestoneWithClosedStatus()
    {
        $expectedValue = [['title' => 'milestone']];
        $data = ['title' => 'milestone', 'status' => 'closed'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/milestones/123', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 123, $data));
    }

    /**
     * @test
     */
    public function shouldSetStateToOpenWhileUpdateWhenStateParamNotRecognized()
    {
        $expectedValue = ['title' => 'l3l0repo'];
        $data = ['title' => 'milestone', 'state' => 'some'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/milestones/123', ['state' => 'open', 'title' => 'milestone'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 123, $data));
    }

    /**
     * @test
     */
    public function shouldSortByDueDateWhenSortParamNotRecognized()
    {
        $expectedValue = [['name' => 'l3l0repo']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/milestones', ['page' => 1, 'state' => 'open', 'sort' => 'due_date', 'direction' => 'asc'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', ['sort' => 'completenes']));
    }

    /**
     * @test
     */
    public function shouldSetStateToOpenWhenStateParamNotRecognized()
    {
        $expectedValue = [['name' => 'l3l0repo']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/milestones', ['page' => 1, 'state' => 'open', 'sort' => 'due_date', 'direction' => 'asc'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', ['state' => 'clos']));
    }

    /**
     * @test
     */
    public function shouldSetDirectionToDescWhenDirectionParamNotRecognized()
    {
        $expectedValue = [['name' => 'l3l0repo']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/milestones', ['page' => 1, 'state' => 'open', 'sort' => 'due_date', 'direction' => 'asc'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', ['direction' => 'asc']));
    }

    /**
     * @test
     */
    public function shouldRemoveMilestones()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/milestones/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     */
    public function shouldShowMilestone()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/milestones/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     */
    public function shouldGetMilestoneLabels()
    {
        $expectedValue = [['label'], ['label2']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/milestones/123/labels')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->labels('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Issue\Milestones::class;
    }
}
