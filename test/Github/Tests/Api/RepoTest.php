<?php

namespace Github\Tests\Api;

use Github\Tests\ApiTestCase;

class RepoTest extends ApiTestCase
{
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
