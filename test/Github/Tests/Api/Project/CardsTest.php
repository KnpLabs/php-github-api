<?php declare(strict_types=1);

namespace Github\Tests\Api\Project;

use Github\Tests\Api\TestCase;

class CardsTest extends TestCase
{
    public function shouldGetAllColumnCards()
    {
        $expectedValue = [['card1data'], ['card2data']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/projects/columns/123/cards')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all(123));
    }

    public function shouldShowCard()
    {
        $expectedValue = ['card1'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/projects/columns/cards/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show(123));
    }

    public function shouldCreateCard()
    {
        $expectedValue = ['card1data'];
        $data = ['content_id' => '123', 'content_type' => 'Issue'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/projects/columns/1234/cards', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('1234', $data));
    }

    public function shouldUpdateCard()
    {
        $expectedValue = ['note1data'];
        $data = ['note' => 'note test'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/projects/columns/cards/123', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update(123, $data));
    }

    public function shouldRemoveCard()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/projects/columns/cards/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->deleteCard(123));
    }

    public function shouldNotMoveWithoutPosition()
    {
        $data = [];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->move('123', $data);
    }

    public function shouldMoveCard()
    {
        $expectedValue = ['card1'];
        $data = ['position' => 'top'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/projects/columns/cards/123/moves')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->move(123, $data));
    }

    protected function getApiClass(): string
    {
        return \Github\Api\Project\Cards::class;
    }
}
