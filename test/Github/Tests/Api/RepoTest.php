<?php

namespace Github\Tests\Api;

use Github\Tests\ApiTestCase;

class RepoTest extends ApiTestCase
{
    /**
     * @expectedException BadMethodCallException
     */
    public function testThatSearchIsNotSupported()
    {
        $api = $this->getApiMock();

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
