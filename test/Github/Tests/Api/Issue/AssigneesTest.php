<?php

namespace Github\Tests\Api\Issue;

use Github\Api\Issue\Assignees;
use Github\Tests\Api\TestCase;

class AssigneesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldListAvailableAssignees()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/knplabs/php-github-api/assignees');

        $api->listAvailable('knplabs', 'php-github-api');
    }

    /**
     * @test
     */
    public function shouldCheckAssignee()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/knplabs/php-github-api/assignees/test-user');

        $api->check('knplabs', 'php-github-api', 'test-user');
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotAddAssigneeMissingParameter()
    {
        $data = [];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->add('knplabs', 'php-github-api', 4, $data);
    }

    /**
     * @test
     */
    public function shouldAddAssignee()
    {
        $data = [
            'assignees' => ['test-user'],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/knplabs/php-github-api/issues/4/assignees', $data);

        $api->add('knplabs', 'php-github-api', 4, $data);
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotRemoveAssigneeMissingParameter()
    {
        $data = [];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('delete');

        $api->remove('knplabs', 'php-github-api', 4, $data);
    }

    /**
     * @test
     */
    public function shouldRemoveAssignee()
    {
        $data = [
            'assignees' => ['test-user'],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/knplabs/php-github-api/issues/4/assignees', $data);

        $api->remove('knplabs', 'php-github-api', 4, $data);
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return Assignees::class;
    }
}
