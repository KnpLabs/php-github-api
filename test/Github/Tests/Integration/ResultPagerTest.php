<?php

namespace Github\Tests\Integration;

use Github\ResultPager;

/**
 * @group integration
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

        $pager = $this->createPager();

        $repositories = $pager->fetch($repositoriesApi, 'repositories', ['KnpLabs']);
        $this->assertCount(10, $repositories);

        $repositoriesApi->setPerPage(20);
        $repositories = $pager->fetch($repositoriesApi, 'repositories', ['KnpLabs']);
        $this->assertCount(20, $repositories);
    }

    /**
     * @test
     *
     * response in a search api has different format:
     *
     * {
     *  "total_count": 1,
     *  "incomplete_results": false,
     *  "items": []
     * }
     *
     * and we need to extract result from `items`
     */
    public function shouldGetAllResultsFromSearchApi()
    {
        $searchApi = $this->client->search();
        $searchApi->setPerPage(10);

        $pager = $this->createPager();

        $users = $pager->fetch($searchApi, 'users', ['location:Kyiv']);
        $this->assertCount(10, $users);
    }

    private function createPager()
    {
        return new ResultPager($this->client);
    }
}
