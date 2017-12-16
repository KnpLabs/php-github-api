<?php

namespace Github\Tests\Api\Project;

use Github\Tests\Api\TestCase;

class ColumnsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllProjectColumns()
    {
        $expectedValue = [['column1data'], ['column2data']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/projects/123/columns')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all(123));
    }

    /**
     * @test
     */
    public function shouldShowColumn()
    {
        $expectedValue = ['column1'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/projects/columns/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show(123));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateWithoutName()
    {
        $data = [];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('123', $data);
    }

    /**
     * @test
     */
    public function shouldCreateColumn()
    {
        $expectedValue = ['column1data'];
        $data = ['name' => 'column 1'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/projects/123/columns', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create(123, $data));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotUpdateWithoutName()
    {
        $data = [];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->update('123', $data);
    }

    /**
     * @test
     */
    public function shouldUpdateColumn()
    {
        $expectedValue = ['column1data'];
        $data = ['name' => 'column 1 update'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/projects/columns/123', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update(123, $data));
    }

    /**
     * @test
     */
    public function shouldRemoveCard()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/projects/columns/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->deleteColumn(123));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotMoveWithoutPosition()
    {
        $data = [];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->move('123', $data);
    }

    /**
     * @test
     */
    public function shouldMoveCard()
    {
        $expectedValue = ['card1'];
        $data = ['position' => 'first'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/projects/columns/123/moves')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->move(123, $data));
    }

    /**
     * @test
     */
    public function shouldGetCardsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Project\Cards', $api->cards());
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Project\Columns::class;
    }
}
