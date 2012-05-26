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

        $api->expects($this->once())
            ->method('get')
            ->with('repos/ornicar/php-github-api/issues?state=open');

        $api->getList('ornicar', 'php-github-api', 'open');
    }

    /**
     * @test
     */
    public function shouldBuildValidQueryForGetListWithAdditionalParameters()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('repos/ornicar/php-github-api/issues?milestone=%2A&assignee=l3l0&mentioned=l3l0&labels=bug%2C%40high&sort=created&direction=asc&state=open');

        $api->getList('ornicar', 'php-github-api', 'open', array(
            'milestone' => '*',
            'assignee'  => 'l3l0',
            'mentioned' => 'l3l0',
            'labels'    => 'bug,@high',
            'sort'      => 'created',
            'direction' => 'asc'
        ));
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

        $api->expects($this->once())
            ->method('post')
            ->with('repos/ornicar/php-github-api/issues', array(
                'title' => 'some title',
                'body'  => 'some body'
            ));

        $api->open('ornicar', 'php-github-api', 'some title', 'some body');
    }

    /**
     * @test
     */
    public function shouldBuildValidQueryForClose()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('patch')
            ->with('repos/ornicar/php-github-api/issues/14', array(
                'state' => 'closed',
            ));

        $api->close('ornicar', 'php-github-api', 14);
    }

    /**
     * @test
     */
    public function shouldBuildValidQueryForReOpen()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('patch')
            ->with('repos/ornicar/php-github-api/issues/14', array(
                'state' => 'open',
            ));

        $api->reOpen('ornicar', 'php-github-api', 14);
    }

    /**
     * @test
     */
    public function shouldBuildValidQueryForGetComments()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('repos/ornicar/php-github-api/issues/14/comments');

        $api->getComments('ornicar', 'php-github-api', 14);
    }

    /**
     * @test
     */
    public function shouldBuildValidQueryForGetComment()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('repos/ornicar/php-github-api/issues/comments/666');

        $api->getComment('ornicar', 'php-github-api', 666);
    }

    /**
     * @test
     */
    public function shouldBuildValidQueryForAddComment()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('post')
            ->with('repos/ornicar/php-github-api/issues/14/comments', array(
                'body'  => 'some body'
            ));

        $api->addComment('ornicar', 'php-github-api', 14, 'some body');
    }

    /**
     * @test
     */
    public function shouldBuildValidQueryForGetLabels()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('repos/ornicar/php-github-api/labels');

        $api->getLabels('ornicar', 'php-github-api');
    }

    /**
     * @test
     */
    public function shouldBuildValidQueryForGetLabel()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('repos/ornicar/php-github-api/labels/my-label');

        $api->getLabel('ornicar', 'php-github-api', 'my-label');
    }

    /**
     * @test
     */
    public function shouldBuildValidQueryForAddLabel()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('post')
            ->with('repos/ornicar/php-github-api/labels', array(
                'name'  => 'my-label',
                'color' => 'FFFFFF'
            ));

        $api->addLabel('ornicar', 'php-github-api', 'my-label', 'FFFFFF');
    }

    /**
     * @test
     */
    public function shouldBuildValidQueryForRemoveLabel()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('delete')
            ->with('repos/ornicar/php-github-api/labels/my-label');

        $api->removeLabel('ornicar', 'php-github-api', 'my-label');
    }

    protected function getApiClass()
    {
        return 'Github\Api\Issue';
    }
}
