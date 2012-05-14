<?php

namespace Github\Tests\Api;

use Github\Tests\ApiTestCase;

class CommitTest extends ApiTestCase
{
    public function testGetBranchCommits()
    {
        $api = $this->getApiMock();

        $expectedValue = array('commit' => array(), 'comitter');

        $api->expects($this->at(0))
            ->method('get')
            ->will($this->returnValue(array('sha' => '123')));

        $api->expects($this->at(1))
            ->method('get')
            ->with($this->equalTo('repos/ornicar/php-github-api/commits?sha=123'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->getBranchCommits('ornicar', 'php-github-api', 'v3'));
    }

    protected function getApiClass()
    {
        return 'Github\Api\Commit';
    }
}
