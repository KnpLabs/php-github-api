<?php

namespace Github\Tests\Api;

use Github\Tests\ApiTestCase;

class CommitTest extends ApiTestCase
{
    public function testGetInvalidBranchCommits()
    {
        $api = $this->getApiMock();

        $expectedValue = array('commit' => array(), 'comitter');

        $data = array('sha' => 'v3');

        $api->expects($this->at(0))
            ->method('get')
            ->with('repos/ornicar/php-github-api/commits', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('ornicar', 'php-github-api', $data));
    }

    protected function getApiClass()
    {
        return 'Github\Api\Repository\Commits';
    }
}
