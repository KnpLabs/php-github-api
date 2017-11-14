<?php declare(strict_types=1);

namespace Github\Tests\Api\Issue;

use Github\Api\Issue\Assignees;
use Github\Tests\Api\TestCase;

class AssigneesTest extends TestCase
{
    public function shouldListAvailableAssignees()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/knplabs/php-github-api/assignees');

        $api->listAvailable('knplabs', 'php-github-api');
    }

    public function shouldCheckAssignee()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/knplabs/php-github-api/assignees/test-user');

        $api->check('knplabs', 'php-github-api', 'test-user');
    }

    public function shouldNotAddAssigneeMissingParameter()
    {
        $data = array();

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->add('knplabs', 'php-github-api', 4, $data);
    }

    public function shouldAddAssignee()
    {
        $data = array(
            'assignees' => array('test-user')
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/knplabs/php-github-api/issues/4/assignees', $data);

        $api->add('knplabs', 'php-github-api', 4, $data);
    }

    public function shouldNotRemoveAssigneeMissingParameter()
    {
        $data = array();

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('delete');

        $api->remove('knplabs', 'php-github-api', 4, $data);
    }

    public function shouldRemoveAssignee()
    {
        $data = array(
            'assignees' => array('test-user')
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/knplabs/php-github-api/issues/4/assignees', $data);

        $api->remove('knplabs', 'php-github-api', 4, $data);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return Assignees::class;
    }
}
