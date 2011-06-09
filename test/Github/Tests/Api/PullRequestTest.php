<?php

class Github_Tests_Api_PullRequestTest extends Github_Tests_ApiTest
{
    public function testlistPullRequests()
    {
        $api = $this->getApiMock();

        // 1. Test with no last parameter
        $api->expects($this->once())
            ->method('get')
            ->with('pulls/ezsystems/ezpublish/');

        $api->listPullRequests('ezsystems', 'ezpublish' );


        $api = $this->getApiMock();
        // 2. Test with last parameter set to 'open'
        $api->expects($this->once())
            ->method('get')
            ->with('pulls/ezsystems/ezpublish/open');

        $api->listPullRequests('ezsystems', 'ezpublish', 'open' );

        $api = $this->getApiMock();
        // 2. Test with last parameter set to 'closed'
        $api->expects($this->once())
            ->method('get')
            ->with('pulls/ezsystems/ezpublish/closed');

        $api->listPullRequests('ezsystems', 'ezpublish', 'closed' );
    }

    public function testshow()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('pulls/ezsystems/ezpublish/15');

        $api->listPullRequests('ezsystems', 'ezpublish', '15' );
    }

    public function testcreate()
    {
        // 1. Testing with body & title
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('post')
            ->with('pulls/ezsystems/ezpublish',
                    array( 'pull[base]'  => 'master',
                           'pull[head]'  => 'virtualtestbranch',
                           'pull[title]' => 'TITLE : Testing pull-request creation from PHP Gituhub API',
                           'pull[body]'  => 'BODY: Testing pull-request creation from PHP Gituhub API'
                         )
                  );

        $api->create('ezsystems', 'ezpublish', 'master', 'virtualtestbranch',
        			 'TITLE : Testing pull-request creation from PHP Gituhub API',
                     'BODY: Testing pull-request creation from PHP Gituhub API' );


        // 2. Testing with issue ID
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('post')
            ->with('pulls/ezsystems/ezpublish',
                    array( 'pull[base]'   => 'master',
                           'pull[head]'   => 'virtualtestbranch',
                           'pull[issue]'  => 25
                         )
                  );

        $api->create('ezsystems', 'ezpublish', 'master', 'virtualtestbranch', null, null, 25 );
    }

    protected function getApiClass()
    {
        return 'Github_Api_PullRequest';
    }
}
