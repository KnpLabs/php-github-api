<?php

class Github_Tests_Api_CommitTest extends Github_Tests_ApiTest
{
    public function testGetBranchCommits()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('commits/list/ornicar/php-github-api/v3');

        $api->getBranchCommits('ornicar', 'php-github-api', 'v3');
    }

    protected function getApiClass()
    {
        return 'Github_Api_Commit';
    }
}
