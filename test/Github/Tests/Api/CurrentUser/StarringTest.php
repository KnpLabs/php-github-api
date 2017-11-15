<?php declare(strict_types=1);

namespace Github\Tests\Api;

class StarringTest extends TestCase
{
    public function shouldGetStarred()
    {
        $expectedValue = [
            ['name' => 'l3l0/test'],
            ['name' => 'cordoval/test']
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/starred')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all());
    }

    public function shouldCheckStar()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/starred/l3l0/test')
            ->will($this->returnValue(null));

        $this->assertNull($api->check('l3l0', 'test'));
    }

    public function shouldStarUser()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/user/starred/l3l0/test')
            ->will($this->returnValue(null));

        $this->assertNull($api->star('l3l0', 'test'));
    }

    public function shouldUnstarUser()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/user/starred/l3l0/test')
            ->will($this->returnValue(null));

        $this->assertNull($api->unstar('l3l0', 'test'));
    }

    protected function getApiClass(): string
    {
        return \Github\Api\CurrentUser\Starring::class;
    }
}
