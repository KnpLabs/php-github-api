<?php declare(strict_types=1);

namespace Github\Tests\Api;

class SearchTest extends TestCase
{
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

    protected function getApiClass(): string
    {
        return \Github\Api\Search::class;
    }
}
