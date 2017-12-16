<?php

namespace Github\Tests\Api;

class IssueTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetIssues()
    {
        $data = [
            'state' => 'open',
        ];
        $sentData = $data + [
            'page' => 1,
            ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/ornicar/php-github-api/issues', $sentData);

        $api->all('ornicar', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldGetIssuesUsingAdditionalParameters()
    {
        $expectedArray = [['id' => '123']];
        $data = [
            'state' => 'open',
            'milestone' => '*',
            'assignee'  => 'l3l0',
            'mentioned' => 'l3l0',
            'labels'    => 'bug,@high',
            'sort'      => 'created',
            'direction' => 'asc',
        ];
        $sentData = $data + [
            'page' => 1,
            ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/ornicar/php-github-api/issues', $sentData)
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('ornicar', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldShowIssue()
    {
        $expectedArray = ['id' => '123'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/ornicar/php-github-api/issues/14')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('ornicar', 'php-github-api', 14));
    }

    /**
     * @test
     */
    public function shouldCreateIssue()
    {
        $data = [
            'title' => 'some title',
            'body'  => 'some body',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/ornicar/php-github-api/issues', $data);

        $api->create('ornicar', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateIssueWithoutTitle()
    {
        $data = [
            'body'  => 'some body',
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('ornicar', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldCreateIssueWithoutBody()
    {
        $data = [
            'title' => 'some title',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/ornicar/php-github-api/issues', $data);

        $api->create('ornicar', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldCloseIssue()
    {
        $data = [
            'state' => 'closed',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/ornicar/php-github-api/issues/14', $data);

        $api->update('ornicar', 'php-github-api', 14, $data);
    }

    /**
     * @test
     */
    public function shouldReOpenIssue()
    {
        $data = [
            'state' => 'open',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/ornicar/php-github-api/issues/14', $data);

        $api->update('ornicar', 'php-github-api', 14, $data);
    }

    /**
     * @test
     */
    public function shouldSearchOpenIssues()
    {
        $expectedArray = [['id' => '123']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/legacy/issues/search/KnpLabs/php-github-api/open/Invalid%20Commits')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->find('KnpLabs', 'php-github-api', 'open', 'Invalid Commits'));
    }

    /**
     * @test
     */
    public function shouldSearchClosedIssues()
    {
        $expectedArray = [['id' => '123']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/legacy/issues/search/KnpLabs/php-github-api/closed/Invalid%20Commits')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->find('KnpLabs', 'php-github-api', 'closed', 'Invalid Commits'));
    }

    /**
     * @test
     */
    public function shouldSearchOpenIssuesWhenStateNotRecognized()
    {
        $expectedArray = [['id' => '123']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/legacy/issues/search/KnpLabs/php-github-api/open/Invalid%20Commits')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->find('KnpLabs', 'php-github-api', 'abc', 'Invalid Commits'));
    }

    /**
     * @test
     */
    public function shouldGetCommentsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Issue\Comments::class, $api->comments());
    }

    /**
     * @test
     */
    public function shouldGetEventsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Issue\Events::class, $api->events());
    }

    /**
     * @test
     */
    public function shouldGetLabelsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Issue\Labels::class, $api->labels());
    }

    /**
     * @test
     */
    public function shouldGetMilestonesApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Issue\Milestones::class, $api->milestones());
    }

    /**
     * @test
     */
    public function shouldGetTimelineApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Issue\Timeline::class, $api->timeline());
    }

    /**
     * @test
     */
    public function shouldLockIssue()
    {
        $parameters = [];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/knplabs/php-github-api/issues/1/lock', $parameters);

        $api->lock('knplabs', 'php-github-api', '1');
    }

    /**
     * @test
     */
    public function shouldUnlockIssue()
    {
        $parameters = [];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/knplabs/php-github-api/issues/1/lock', $parameters);

        $api->unlock('knplabs', 'php-github-api', '1');
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Issue::class;
    }
}
