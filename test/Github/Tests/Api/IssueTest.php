<?php

namespace Github\Tests\Api;

use Github\Tests\ApiTestCase;

class IssueTest extends ApiTestCase
{
    /**
     * @test
     */
    public function shouldBuildValidQueryForGetList()
    {
        $api = $this->getApiMock();

        $data = array(
            'state' => 'open'
        );
        $sentData = $data + array(
            'page' => 1
        );

        $api->expects($this->once())
            ->method('get')
            ->with('repos/ornicar/php-github-api/issues', $sentData);

        $api->all('ornicar', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldBuildValidQueryForGetListWithAdditionalParameters()
    {
        $api = $this->getApiMock();

        $data = array(
            'state' => 'open',
            'milestone' => '*',
            'assignee'  => 'l3l0',
            'mentioned' => 'l3l0',
            'labels'    => 'bug,@high',
            'sort'      => 'created',
            'direction' => 'asc'
        );

        $sentData = $data + array(
            'page' => 1
        );

        $api->expects($this->once())
            ->method('get')
            ->with('repos/ornicar/php-github-api/issues', $sentData);

        $api->all('ornicar', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldBuildValidQueryForShow()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('repos/ornicar/php-github-api/issues/14');

        $api->show('ornicar', 'php-github-api', 14);
    }

    /**
     * @test
     */
    public function shouldBuildValidQueryForOpen()
    {
        $api = $this->getApiMock();

        $data = array(
            'title' => 'some title',
            'body'  => 'some body'
        );

        $api->expects($this->once())
            ->method('post')
            ->with('repos/ornicar/php-github-api/issues', $data);

        $api->create('ornicar', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldBuildValidQueryForClose()
    {
        $api = $this->getApiMock();

        $data = array(
            'state' => 'closed',
        );

        $api->expects($this->once())
            ->method('patch')
            ->with('repos/ornicar/php-github-api/issues/14', $data);

        $api->update('ornicar', 'php-github-api', 14, $data);
    }

    /**
     * @test
     */
    public function shouldBuildValidQueryForReOpen()
    {
        $api = $this->getApiMock();

        $data = array(
            'state' => 'open',
        );

        $api->expects($this->once())
            ->method('patch')
            ->with('repos/ornicar/php-github-api/issues/14', $data);

        $api->update('ornicar', 'php-github-api', 14, $data);
    }

    protected function getApiClass()
    {
        return 'Github\Api\Issue';
    }
}
