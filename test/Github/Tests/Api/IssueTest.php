<?php

class Github_Tests_Api_IssueTest extends Github_Tests_ApiTest
{
    public function testGetList()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('issues/list/ornicar/php-github-api/open');

        $api->getList('ornicar', 'php-github-api', 'open');
    }

    protected function getApiClass()
    {
        return 'Github_Api_Issue';
    }
}
