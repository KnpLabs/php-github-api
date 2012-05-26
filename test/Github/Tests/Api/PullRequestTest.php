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

        $api->listPullRequests('ezsystems', 'ezpublish' );


        $api = $this->getApiMock();
        // 2. Test with last parameter set to 'open'
        $api->expects($this->once())
            ->method('get')
            ->with('repos/ezsystems/ezpublish/pulls?state=open');

        $api->listPullRequests('ezsystems', 'ezpublish', 'open' );

        $api = $this->getApiMock();
        // 2. Test with last parameter set to 'closed'
        $api->expects($this->once())
            ->method('get')
            ->with('repos/ezsystems/ezpublish/pulls?state=closed');

        $api->listPullRequests('ezsystems', 'ezpublish', 'closed' );
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

        $api->show('ezsystems', 'ezpublish', '15' );
    }

    /**
     * @test
     */
    public function shouldCreateValidQueryForCreate()
    {
        // 1. Testing with body & title
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('post')
            ->with('repos/ezsystems/ezpublish/pulls',
                    array( 'base'  => 'master',
                           'head'  => 'virtualtestbranch',
                           'title' => 'TITLE : Testing pull-request creation from PHP Gituhub API',
                           'body'  => 'BODY: Testing pull-request creation from PHP Gituhub API'
                         )
                  );

        $api->create('ezsystems', 'ezpublish', 'master', 'virtualtestbranch',
                     'TITLE : Testing pull-request creation from PHP Gituhub API',
                     'BODY: Testing pull-request creation from PHP Gituhub API' );


        // 2. Testing with issue ID
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('post')
            ->with('repos/ezsystems/ezpublish/pulls',
                    array( 'base'   => 'master',
                           'head'   => 'virtualtestbranch',
                           'issue'  => 25
                         )
                  );

        $api->create('ezsystems', 'ezpublish', 'master', 'virtualtestbranch', null, null, 25 );

        // 3. Testing with title and issue ID
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('post')
            ->with('repos/ezsystems/ezpublish/pulls',
                    array( 'base'   => 'master',
                           'head'   => 'virtualtestbranch',
                           'title'  => 'some title',
                           'body'   => null
                         )
                  );

        $api->create('ezsystems', 'ezpublish', 'master', 'virtualtestbranch', 'some title', null, 25 );
    }

    protected function getApiClass()
    {
        return 'Github\Api\PullRequest';
    }
}
