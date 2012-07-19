<?php

namespace Github\Tests\Api;

use Github\Tests\ApiTestCase;

class PullRequestTest extends ApiTestCase
{
    /**
     * @test
     */
    public function shouldCreateValidQueryForListPullRequests()
    {
        $api = $this->getApiMock();

        // 1. Test with no last parameter
        $api->expects($this->once())
            ->method('get')
            ->with('repos/ezsystems/ezpublish/pulls');

        $api->all('ezsystems', 'ezpublish');


        // 2. Test with last parameter set to 'open'
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/ezsystems/ezpublish/pulls', array('state' => 'open'));

        $api->all('ezsystems', 'ezpublish', 'open');

        // 2. Test with last parameter set to 'closed'
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/ezsystems/ezpublish/pulls', array('state' => 'closed'));

        $api->all('ezsystems', 'ezpublish', 'closed');
    }

    /**
     * @test
     */
    public function shouldCreateValidQueryForShow()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('repos/ezsystems/ezpublish/pulls/15');

        $api->show('ezsystems', 'ezpublish', '15');
    }

    /**
     * @test
     */
    public function shouldCreateValidQueryForCreate()
    {
        // 1. Testing with body & title
        $api = $this->getApiMock();

        $data = array(
            'base'  => 'master',
            'head'  => 'virtualtestbranch',
            'title' => 'TITLE: Testing pull-request creation from PHP Github API',
            'body'  => 'BODY: Testing pull-request creation from PHP Github API'
        );

        $api->expects($this->once())
            ->method('post')
            ->with('repos/ezsystems/ezpublish/pulls', $data);

        $api->create('ezsystems', 'ezpublish', $data);

        // 2. Testing with issue ID
        $api = $this->getApiMock();

        $data = array(
            'base'  => 'master',
            'head'  => 'virtualtestbranch',
            'issue' => 25
        );

        $api->expects($this->once())
            ->method('post')
            ->with('repos/ezsystems/ezpublish/pulls', $data);

        $api->create('ezsystems', 'ezpublish', $data);
    }

    protected function getApiClass()
    {
        return 'Github\Api\PullRequest';
    }
}
