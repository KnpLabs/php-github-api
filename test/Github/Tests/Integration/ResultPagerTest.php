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

        $pager = $this->createPager();
        $users = $pager->fetch($searchApi, 'users', ['location:Kyiv']);
        $this->assertCount(10, $users);
    }

    private function createPager()
    {
        return new ResultPager($this->client);
    }
}
