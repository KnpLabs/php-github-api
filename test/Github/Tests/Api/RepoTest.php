<?php

namespace Github\Tests\Api;

use Github\Tests\ApiTestCase;

class RepoTest extends ApiTestCase
{
    public function testSearch()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('repos/search/github+api', array(
                'language' => 'fr',
                'start_page' => 3
            ));

        $api->search('github api', 'fr', 3);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testThatPushableReposIsNotSupported()
    {
        $api = $this->getApiMock();

        $api->getPushableRepos();
    }

    protected function getApiClass()
    {
        return 'Github\Api\Repo';
    }
}
