<?php declare(strict_types=1);

namespace Github\Tests\Api\Issue;

use Github\Tests\Api\TestCase;

class MilestonesTest extends TestCase
{
    public function shouldGetMilestones()
    {
        $expectedValue = array(array('name' => 'l3l0repo'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/milestones', array('page' => 1, 'state' => 'open', 'sort' => 'due_date', 'direction' => 'asc'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    public function shouldCreateMilestone()
    {
        $expectedValue = array(array('title' => 'milestone'));
        $data = array('title' => 'milestone');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/milestones', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    public function shouldNotCreateMilestoneWithoutTitle()
    {
        $expectedValue = array(array('title' => 'milestone'));
        $data = array();

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    public function shouldSetStateToOpenWhileCreationWhenStateParamNotRecognized()
    {
        $expectedValue = array('title' => 'l3l0repo');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/milestones', array('state' => 'open', 'title' => 'milestone'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', array('state' => 'clos', 'title' => 'milestone')));
    }

    public function shouldUpdateMilestone()
    {
        $expectedValue = array(array('title' => 'milestone'));
        $data = array('title' => 'milestone');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/milestones/123', array('title' => 'milestone'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 123, $data));
    }

    public function shouldUpdateMilestoneWithClosedStatus()
    {
        $expectedValue = array(array('title' => 'milestone'));
        $data = array('title' => 'milestone', 'status' => 'closed');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/milestones/123', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 123, $data));
    }

    public function shouldSetStateToOpenWhileUpdateWhenStateParamNotRecognized()
    {
        $expectedValue = array('title' => 'l3l0repo');
        $data = array('title' => 'milestone', 'state' => 'some');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/milestones/123', array('state' => 'open', 'title' => 'milestone'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 123, $data));
    }

    public function shouldSortByDueDateWhenSortParamNotRecognized()
    {
        $expectedValue = array(array('name' => 'l3l0repo'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/milestones', array('page' => 1, 'state' => 'open', 'sort' => 'due_date', 'direction' => 'asc'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', array('sort' => 'completenes')));
    }

    public function shouldSetStateToOpenWhenStateParamNotRecognized()
    {
        $expectedValue = array(array('name' => 'l3l0repo'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/milestones', array('page' => 1, 'state' => 'open', 'sort' => 'due_date', 'direction' => 'asc'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', array('state' => 'clos')));
    }

    public function shouldSetDirectionToDescWhenDirectionParamNotRecognized()
    {
        $expectedValue = array(array('name' => 'l3l0repo'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/milestones', array('page' => 1, 'state' => 'open', 'sort' => 'due_date', 'direction' => 'asc'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', array('direction' => 'asc')));
    }

    public function shouldRemoveMilestones()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/milestones/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 123));
    }

    public function shouldShowMilestone()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/milestones/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    public function shouldGetMilestoneLabels()
    {
        $expectedValue = array(array('label'), array('label2'));

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
    protected function getApiClass(): string
    {
        return \Github\Api\Issue\Milestones::class;
    }
}
