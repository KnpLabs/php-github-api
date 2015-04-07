<?php

namespace Github\Tests\Api;

class SearchTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSearchRepositoriesByQuery()
    {
        $expectedArray = array(array('total_count' => '0'));

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with(
                'search/repositories',
                array('q' => 'query text', 'sort' => 'updated', 'order' => 'desc')
            )
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->repositories('query text'));
    }

    /**
     * @test
     */
    public function shouldSearchRepositoriesRegardingSortAndOrder()
    {
        $expectedArray = array(array('total_count' => '0'));

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with(
                'search/repositories',
                array('q' => 'query text', 'sort' => 'created', 'order' => 'asc')
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
        $expectedArray = array(array('total_count' => '0'));

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with(
                'search/issues',
                array('q' => 'query text', 'sort' => 'updated', 'order' => 'desc')
            )
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->issues('query text'));
    }

    /**
     * @test
     */
    public function shouldSearchIssuesRegardingSortAndOrder()
    {
        $expectedArray = array(array('total_count' => '0'));

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with(
                'search/issues',
                array('q' => 'query text', 'sort' => 'created', 'order' => 'asc')
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
        $expectedArray = array(array('total_count' => '0'));

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with(
                'search/code',
                array('q' => 'query text', 'sort' => 'updated', 'order' => 'desc')
            )
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->code('query text'));
    }

    /**
     * @test
     */
    public function shouldSearchCodeRegardingSortAndOrder()
    {
        $expectedArray = array(array('total_count' => '0'));

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with(
                'search/code',
                array('q' => 'query text', 'sort' => 'created', 'order' => 'asc')
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
        $expectedArray = array(array('total_count' => '0'));

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with(
                'search/users',
                array('q' => 'query text', 'sort' => 'updated', 'order' => 'desc')
            )
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->users('query text'));
    }

    /**
     * @test
     */
    public function shouldSearchUsersRegardingSortAndOrder()
    {
        $expectedArray = array(array('total_count' => '0'));

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with(
                'search/users',
                array('q' => 'query text', 'sort' => 'created', 'order' => 'asc')
            )
            ->will($this->returnValue($expectedArray));

        $this->assertEquals(
            $expectedArray,
            $api->users('query text', 'created', 'asc')
        );
    }

    protected function getApiClass()
    {
        return 'Github\Api\Search';
    }
}
