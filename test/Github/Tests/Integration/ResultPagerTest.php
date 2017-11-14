<?php declare(strict_types=1);

namespace Github\Tests\Integration;

use Github\ResultPager;

/**
 * @group integration
 */
class ResultPagerTest extends TestCase
{
    public function shouldPaginateGetRequests()
    {
        $repositoriesApi = $this->client->api('user');
        $repositoriesApi->setPerPage(10);

        $pager = $this->createPager();

        $repositories = $pager->fetch($repositoriesApi, 'repositories', array('KnpLabs'));
        $this->assertCount(10, $repositories);

        $repositoriesApi->setPerPage(20);
        $repositories = $pager->fetch($repositoriesApi, 'repositories', array('KnpLabs'));
        $this->assertCount(20, $repositories);
    }

    public function shouldGetAllResultsFromSearchApi()
    {
        $searchApi = $this->client->search();
        $searchApi->setPerPage(10);

        $pager = $this->createPager();

        $users = $pager->fetch($searchApi, 'users', array('location:Kyiv'));
        $this->assertCount(10, $users);
    }

    private function createPager()
    {
        return new ResultPager($this->client);
    }
}
