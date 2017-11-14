<?php declare(strict_types=1);

namespace Github\Tests\Api\Project;

use Github\Tests\Api\TestCase;

class ColumnsTest extends TestCase
{
    public function shouldGetAllProjectColumns()
    {
        $expectedValue = array(array('column1data'), array('column2data'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/projects/123/columns')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all(123));
    }

    public function shouldShowColumn()
    {
        $expectedValue = array('column1');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/projects/columns/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show(123));
    }

    public function shouldNotCreateWithoutName()
    {
        $data = array();

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('123', $data);
    }

    public function shouldCreateColumn()
    {
        $expectedValue = array('column1data');
        $data = array('name' => 'column 1');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/projects/123/columns', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create(123, $data));
    }

    public function shouldNotUpdateWithoutName()
    {
        $data = array();

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->update('123', $data);
    }

    public function shouldUpdateColumn()
    {
        $expectedValue = array('column1data');
        $data = array('name' => 'column 1 update');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/projects/columns/123', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update(123, $data));
    }

    public function shouldRemoveCard()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/projects/columns/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->deleteColumn(123));
    }

    public function shouldNotMoveWithoutPosition()
    {
        $data = array();

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->move('123', $data);
    }

    public function shouldMoveCard()
    {
        $expectedValue = array('card1');
        $data = array('position' => 'first');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/projects/columns/123/moves')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->move(123, $data));
    }

    public function shouldGetCardsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Project\Cards', $api->cards());
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\Project\Columns::class;
    }
}
