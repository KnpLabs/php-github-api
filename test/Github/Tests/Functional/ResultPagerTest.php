<?php

namespace Github\Tests\Functional;

use Github\ResultPager;

/**
 * @group functional
 */
class ResultPagerTest extends TestCase
{
    /**
     * @test
     */
    public function shouldPaginateGetRequests()
    {
        $repositoriesApi = $this->client->api('user');
        $repositoriesApi->setPerPage(10);

        $pager = new ResultPager($this->client);

        $repositories = $pager->fetch($repositoriesApi, 'repositories', array('KnpLabs'));
        $this->assertCount(10, $repositories);

        $repositoriesApi->setPerPage(20);
        $repositories = $pager->fetch($repositoriesApi, 'repositories', array('KnpLabs'));
        $this->assertCount(20, $repositories);
    }
}
