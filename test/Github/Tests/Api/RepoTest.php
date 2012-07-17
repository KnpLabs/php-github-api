<?php

namespace Github\Tests\Api;

use Github\Tests\ApiTestCase;

class RepoTest extends ApiTestCase
{
    public function testShow()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api');

        $api->show('KnpLabs', 'php-github-api');
    }

    protected function getApiClass()
    {
        return 'Github\Api\Repo';
    }
}
