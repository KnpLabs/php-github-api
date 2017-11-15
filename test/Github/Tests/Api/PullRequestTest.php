<?php declare(strict_types=1);

namespace Github\Tests\Api;

class PullRequestTest extends TestCase
{
    public function shouldGetAllPullRequests()
    {
        $expectedArray = ['pr1', 'pr2'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/ezsystems/ezpublish/pulls')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('ezsystems', 'ezpublish'));
    }

    public function shouldGetOpenPullRequests()
    {
        $expectedArray = ['pr1', 'pr2'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/ezsystems/ezpublish/pulls', ['state' => 'open', 'per_page' => 30, 'page' => 1])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('ezsystems', 'ezpublish', ['state' => 'open']));
    }

    public function shouldGetClosedPullRequests()
    {
        $expectedArray = ['pr1', 'pr2'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/ezsystems/ezpublish/pulls', ['state' => 'closed', 'per_page' => 30, 'page' => 1])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('ezsystems', 'ezpublish', ['state' => 'closed']));
    }

    public function shouldShowPullRequest()
    {
        $expectedArray = ['id' => 'id', 'sha' => '123123'];

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('/repos/ezsystems/ezpublish/pulls/15')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('ezsystems', 'ezpublish', '15'));
    }

    public function shouldShowCommitsFromPullRequest()
    {
        $expectedArray = [['id' => 'id', 'sha' => '123123']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/ezsystems/ezpublish/pulls/15/commits')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->commits('ezsystems', 'ezpublish', '15'));
    }

    public function shouldShowFilesFromPullRequest()
    {
        $expectedArray = [['id' => 'id', 'sha' => '123123']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/ezsystems/ezpublish/pulls/15/files')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->files('ezsystems', 'ezpublish', '15'));
    }

    public function shouldShowStatusesFromPullRequest()
    {
        $expectedArray = [['id' => 'id', 'sha' => '123123']];
        $expectedArray['_links']['statuses']['href'] = '/repos/ezsystems/ezpublish/pulls/15/statuses';

        $api = $this->getApiMock();
        $api->expects($this->at(0))
            ->method('get')
            ->with('/repos/ezsystems/ezpublish/pulls/15')
            ->will($this->returnValue($expectedArray));

        $api->expects($this->at(1))
            ->method('get')
            ->with('/repos/ezsystems/ezpublish/pulls/15/statuses')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->status('ezsystems', 'ezpublish', '15'));
    }

    public function shouldUpdatePullRequests()
    {
        $expectedArray = ['id' => 15, 'sha' => '123123'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/ezsystems/ezpublish/pulls/15', ['state' => 'open', 'some' => 'param'])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update('ezsystems', 'ezpublish', 15, ['state' => 'aa', 'some' => 'param']));
    }

    public function shouldCheckIfPullRequestIsMerged()
    {
        $expectedArray = ['some' => 'response'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/ezsystems/ezpublish/pulls/15/merge')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->merged('ezsystems', 'ezpublish', 15));
    }

    public function shouldMergePullRequest()
    {
        $expectedArray = ['some' => 'response'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/ezsystems/ezpublish/pulls/15/merge', ['commit_message' => 'Merged something', 'sha' => str_repeat('A', 40), 'merge_method' => 'merge'])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->merge('ezsystems', 'ezpublish', 15, 'Merged something', str_repeat('A', 40)));
    }

    public function shouldMergePullRequestWithSquashAsBool()
    {
        $expectedArray = ['some' => 'response'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/ezsystems/ezpublish/pulls/15/merge', ['commit_message' => 'Merged something', 'sha' => str_repeat('A', 40), 'merge_method' => 'squash'])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->merge('ezsystems', 'ezpublish', 15, 'Merged something', str_repeat('A', 40), true));
    }

    public function shouldMergePullRequestWithMergeMethod()
    {
        $expectedArray = ['some' => 'response'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/ezsystems/ezpublish/pulls/15/merge', ['commit_message' => 'Merged something', 'sha' => str_repeat('A', 40), 'merge_method' => 'rebase'])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->merge('ezsystems', 'ezpublish', 15, 'Merged something', str_repeat('A', 40), 'rebase'));
    }

    public function shouldCreatePullRequestUsingTitle()
    {
        $data = [
            'base' => 'master',
            'head' => 'virtualtestbranch',
            'title' => 'TITLE: Testing pull-request creation from PHP Github API',
            'body' => 'BODY: Testing pull-request creation from PHP Github API',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/ezsystems/ezpublish/pulls', $data);

        $api->create('ezsystems', 'ezpublish', $data);
    }

    public function shouldCreatePullRequestUsingIssueId()
    {
        $data = [
            'base' => 'master',
            'head' => 'virtualtestbranch',
            'issue' => 25,
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/ezsystems/ezpublish/pulls', $data);

        $api->create('ezsystems', 'ezpublish', $data);
    }

    public function shouldNotCreatePullRequestWithoutBase()
    {
        $data = [
            'head' => 'virtualtestbranch',
            'title' => 'TITLE: Testing pull-request creation from PHP Github API',
            'body' => 'BODY: Testing pull-request creation from PHP Github API',
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('ezsystems', 'ezpublish', $data);
    }

    public function shouldNotCreatePullRequestWithoutHead()
    {
        $data = [
            'base' => 'master',
            'title' => 'TITLE: Testing pull-request creation from PHP Github API',
            'body' => 'BODY: Testing pull-request creation from PHP Github API',
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('ezsystems', 'ezpublish', $data);
    }

    public function shouldNotCreatePullRequestUsingTitleButWithoutBody()
    {
        $data = [
            'base' => 'master',
            'head' => 'virtualtestbranch',
            'title' => 'TITLE: Testing pull-request creation from PHP Github API',
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('ezsystems', 'ezpublish', $data);
    }

    public function shouldNotCreatePullRequestWithoutIssueIdOrTitle()
    {
        $data = [
            'base' => 'master',
            'head' => 'virtualtestbranch',
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('ezsystems', 'ezpublish', $data);
    }

    public function shouldGetCommentsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\PullRequest\Comments::class, $api->comments());
    }

    public function shouldGetReviewApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\PullRequest\Review::class, $api->reviews());
    }

    protected function getApiClass(): string
    {
        return \Github\Api\PullRequest::class;
    }
}
