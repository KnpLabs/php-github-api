<?php

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class ColumnsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllProjectColumns()
    {
        $expectedValue = array(array('column1data'), array('column2data'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/projects/123/columns')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     */
    public function shouldShowColumn()
    {
        $expectedValue = array('column1');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/projects/columns/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateWithoutName()
    {
        $data = array();

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', '123', $data);
    }

    /**
     * @test
     */
    public function shouldCreateColumn()
    {
        $expectedValue = array('column1data');
        $data = array('name' => 'column 1');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/projects/123/columns', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', 123, $data));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotUpdateWithoutName()
    {
        $data = array();

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->update('KnpLabs', 'php-github-api', '123', $data);
    }

    /**
     * @test
     */
    public function shouldUpdateColumn()
    {
        $expectedValue = array('column1data');
        $data = array('name' => 'column 1 update');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/projects/columns/123', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 123, $data));
    }

    /**
     * @test
     */
    public function shouldRemoveCard()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/projects/columns/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->deleteColumn('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotMoveWithoutPosition()
    {
        $data = array();

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->move('KnpLabs', 'php-github-api', '123', $data);
    }

    /**
     * @test
     */
    public function shouldMoveCard()
    {
        $expectedValue = array('card1');
        $data = array('position' => 'first');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/projects/columns/123/moves')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->move('KnpLabs', 'php-github-api', 123, $data));
    }

    /**
     * @test
     */
    public function shouldGetCardsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Repository\Cards', $api->cards());
    }

    protected function getApiClass()
    {
        return 'Github\Api\Repository\Columns';
    }
}
