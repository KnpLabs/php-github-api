<?php

namespace Github\Tests\Api;

class PullRequestTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllPullRequests()
    {
        $expectedArray = array('pr1', 'pr2');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/ezsystems/ezpublish/pulls')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('ezsystems', 'ezpublish'));
    }

    /**
     * @test
     */
    public function shouldGetOpenPullRequests()
    {
        $expectedArray = array('pr1', 'pr2');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/ezsystems/ezpublish/pulls', array('state' => 'open'))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('ezsystems', 'ezpublish', 'open'));
    }

    /**
     * @test
     */
    public function shouldGetClosedPullRequests()
    {
        $expectedArray = array('pr1', 'pr2');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/ezsystems/ezpublish/pulls', array('state' => 'closed'))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('ezsystems', 'ezpublish', 'closed'));
    }

    /**
     * @test
     */
    public function shouldShowPullRequest()
    {
        $expectedArray = array('id' => 'id', 'sha' => '123123');

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('repos/ezsystems/ezpublish/pulls/15')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('ezsystems', 'ezpublish', '15'));
    }

    /**
     * @test
     */
    public function shouldShowCommitsFromPullRequest()
    {
        $expectedArray = array(array('id' => 'id', 'sha' => '123123'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/ezsystems/ezpublish/pulls/15/commits')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->commits('ezsystems', 'ezpublish', '15'));
    }

    /**
     * @test
     */
    public function shouldShowFilesFromPullRequest()
    {
        $expectedArray = array(array('id' => 'id', 'sha' => '123123'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/ezsystems/ezpublish/pulls/15/files')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->files('ezsystems', 'ezpublish', '15'));
    }

    /**
     * @test
     */
    public function shouldUpdatePullRequests()
    {
        $expectedArray = array('id' => 'id', 'sha' => '123123');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('repos/ezsystems/ezpublish/pulls', array('state' => 'open', 'some' => 'param'))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update('ezsystems', 'ezpublish', array('state' => 'aa', 'some' => 'param')));
    }

    /**
     * @test
     */
    public function shouldCheckIfPullRequestIsMerged()
    {
        $expectedArray = array('some' => 'response');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/ezsystems/ezpublish/pulls/15/merge')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->merged('ezsystems', 'ezpublish', 15));
    }

    /**
     * @test
     */
    public function shouldMergePullRequest()
    {
        $expectedArray = array('some' => 'response');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('repos/ezsystems/ezpublish/pulls/15/merge', array('commit_message' => 'Merged something'))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->merge('ezsystems', 'ezpublish', 15, 'Merged something'));
    }

    /**
     * @test
     */
    public function shouldCreatePullRequestUsingTitle()
    {
        $data = array(
            'base'  => 'master',
            'head'  => 'virtualtestbranch',
            'title' => 'TITLE: Testing pull-request creation from PHP Github API',
            'body'  => 'BODY: Testing pull-request creation from PHP Github API'
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('repos/ezsystems/ezpublish/pulls', $data);

        $api->create('ezsystems', 'ezpublish', $data);
    }

    /**
     * @test
     */
    public function shouldCreatePullRequestUsingIssueId()
    {
        $data = array(
            'base'  => 'master',
            'head'  => 'virtualtestbranch',
            'issue' => 25
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('repos/ezsystems/ezpublish/pulls', $data);

        $api->create('ezsystems', 'ezpublish', $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreatePullRequestWithoutBase()
    {
        $data = array(
            'head'  => 'virtualtestbranch',
            'title' => 'TITLE: Testing pull-request creation from PHP Github API',
            'body'  => 'BODY: Testing pull-request creation from PHP Github API'
        );

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('ezsystems', 'ezpublish', $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreatePullRequestWithoutHead()
    {
        $data = array(
            'base'  => 'master',
            'title' => 'TITLE: Testing pull-request creation from PHP Github API',
            'body'  => 'BODY: Testing pull-request creation from PHP Github API'
        );

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('ezsystems', 'ezpublish', $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreatePullRequestUsingTitleButWithoutBody()
    {
        $data = array(
            'base'  => 'master',
            'head'  => 'virtualtestbranch',
            'title' => 'TITLE: Testing pull-request creation from PHP Github API',
        );

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('ezsystems', 'ezpublish', $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreatePullRequestWithoutIssueIdOrTitle()
    {
        $data = array(
            'base'  => 'master',
            'head'  => 'virtualtestbranch',
        );

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('ezsystems', 'ezpublish', $data);
    }

    /**
     * @test
     */
    public function shouldGetCommentsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\PullRequest\Comments', $api->comments());
    }

    protected function getApiClass()
    {
        return 'Github\Api\PullRequest';
    }
}
