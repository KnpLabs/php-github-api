<?php

namespace Github\Tests\Api;

class IssueTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetIssues()
    {
        $data = array(
            'state' => 'open'
        );
        $sentData = $data + array(
            'page' => 1
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/ornicar/php-github-api/issues', $sentData);

        $api->all('ornicar', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldGetIssuesUsingAdditionalParameters()
    {
        $expectedArray = array(array('id' => '123'));
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

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/ornicar/php-github-api/issues', $sentData)
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('ornicar', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldShowIssue()
    {
        $expectedArray = array('id' => '123');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/ornicar/php-github-api/issues/14')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('ornicar', 'php-github-api', 14));
    }

    /**
     * @test
     */
    public function shouldCreateIssue()
    {
        $data = array(
            'title' => 'some title',
            'body'  => 'some body'
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('repos/ornicar/php-github-api/issues', $data);

        $api->create('ornicar', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateIssueWithoutTitle()
    {
        $data = array(
            'body'  => 'some body'
        );

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('ornicar', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateIssueWithoutBody()
    {
        $data = array(
            'title' => 'some title'
        );

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('ornicar', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldCloseIssue()
    {
        $data = array(
            'state' => 'closed',
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('repos/ornicar/php-github-api/issues/14', $data);

        $api->update('ornicar', 'php-github-api', 14, $data);
    }

    /**
     * @test
     */
    public function shouldReOpenIssue()
    {
        $data = array(
            'state' => 'open',
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('repos/ornicar/php-github-api/issues/14', $data);

        $api->update('ornicar', 'php-github-api', 14, $data);
    }

    /**
     * @test
     */
    public function shouldSearchOpenIssues()
    {
        $expectedArray = array(array('id' => '123'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('legacy/issues/search/KnpLabs/php-github-api/open/Invalid+Commits')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->find('KnpLabs', 'php-github-api', 'open', 'Invalid Commits'));
    }

    /**
     * @test
     */
    public function shouldSearchClosedIssues()
    {
        $expectedArray = array(array('id' => '123'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('legacy/issues/search/KnpLabs/php-github-api/closed/Invalid+Commits')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->find('KnpLabs', 'php-github-api', 'closed', 'Invalid Commits'));
    }

    /**
     * @test
     */
    public function shouldSearchOpenIssuesWhenStateNotRecognized()
    {
        $expectedArray = array(array('id' => '123'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('legacy/issues/search/KnpLabs/php-github-api/open/Invalid+Commits')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->find('KnpLabs', 'php-github-api', 'abc', 'Invalid Commits'));
    }

    /**
     * @test
     */
    public function shouldGetCommentsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Issue\Comments', $api->comments());
    }

    /**
     * @test
     */
    public function shouldGetEventsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Issue\Events', $api->events());
    }

    /**
     * @test
     */
    public function shouldGetLabelsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Issue\Labels', $api->labels());
    }

    /**
     * @test
     */
    public function shouldGetMilestonesApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Issue\Milestones', $api->milestones());
    }

    protected function getApiClass()
    {
        return 'Github\Api\Issue';
    }
}
