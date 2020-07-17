<?php

namespace Github\Tests\Api;

class SearchTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSearchRepositoriesByQuery()
    {
        $expectedArray = [['total_count' => '0']];

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with(
                '/search/repositories',
                ['q' => 'query text', 'sort' => 'updated', 'order' => 'desc']
            )
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->repositories('query text'));
    }

    /**
     * @test
     */
    public function shouldSearchRepositoriesRegardingSortAndOrder()
    {
        $expectedArray = [['total_count' => '0']];

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with(
                '/search/repositories',
                ['q' => 'query text', 'sort' => 'created', 'order' => 'asc']
            )
            ->will($this->returnValue($expectedArray));

        $this->assertEquals(
            $expectedArray,
            $api->repositories('query text', 'created', 'asc')
        );
    }

    /**
     * @test
     */
    public function shouldSearchIssuesByQuery()
    {
        $expectedArray = [['total_count' => '0']];

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with(
                '/search/issues',
                ['q' => 'query text', 'sort' => 'updated', 'order' => 'desc']
            )
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->issues('query text'));
    }

    /**
     * @test
     */
    public function shouldSearchIssuesRegardingSortAndOrder()
    {
        $expectedArray = [['total_count' => '0']];

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with(
                '/search/issues',
                ['q' => 'query text', 'sort' => 'created', 'order' => 'asc']
            )
            ->will($this->returnValue($expectedArray));

        $this->assertEquals(
            $expectedArray,
            $api->issues('query text', 'created', 'asc')
        );
    }

    /**
     * @test
     */
    public function shouldSearchCodeByQuery()
    {
        $expectedArray = [['total_count' => '0']];

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with(
                '/search/code',
                ['q' => 'query text', 'sort' => 'updated', 'order' => 'desc']
            )
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->code('query text'));
    }

    /**
     * @test
     */
    public function shouldSearchCodeRegardingSortAndOrder()
    {
        $expectedArray = [['total_count' => '0']];

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with(
                '/search/code',
                ['q' => 'query text', 'sort' => 'created', 'order' => 'asc']
            )
            ->will($this->returnValue($expectedArray));

        $this->assertEquals(
            $expectedArray,
            $api->code('query text', 'created', 'asc')
        );
    }

    /**
     * @test
     */
    public function shouldSearchUsersByQuery()
    {
        $expectedArray = [['total_count' => '0']];

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with(
                '/search/users',
                ['q' => 'query text', 'sort' => 'updated', 'order' => 'desc']
            )
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->users('query text'));
    }

    /**
     * @test
     */
    public function shouldSearchUsersRegardingSortAndOrder()
    {
        $expectedArray = [['total_count' => '0']];

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with(
                '/search/users',
                ['q' => 'query text', 'sort' => 'created', 'order' => 'asc']
            )
            ->will($this->returnValue($expectedArray));

        $this->assertEquals(
            $expectedArray,
            $api->users('query text', 'created', 'asc')
        );
    }

    /**
     * @test
     */
    public function shouldSearchCommitsRegardingSortAndOrder()
    {
        $expectedArray = ['total_count' => '0'];

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('/search/commits', ['q' => 'query text', 'sort' => 'author-date', 'order' => 'asc'])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals(
            $expectedArray,
            $api->commits('query text', 'author-date', 'asc')
        );
    }

    /**
     * @test
     */
    public function shouldSearchTopics()
    {
        $expectedArray = ['total_count' => '0'];

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('/search/topics', ['q' => 'query text'])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals(
            $expectedArray,
            $api->topics('query text')
        );
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Search::class;
    }
}
