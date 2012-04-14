<?php

namespace Github\Tests\Api;

use Github\Tests\ApiTestCase;

class IssueTest extends ApiTestCase
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
        return 'Github\Api\Issue';
    }
}
