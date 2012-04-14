<?php

namespace Github\Tests\Api;

use Github\Tests\ApiTestCase;

class CommitTest extends ApiTestCase
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
        return 'Github\Api\Commit';
    }
}
