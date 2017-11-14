<?php declare(strict_types=1);

namespace Github\Tests\Api\Enterprise;

use Github\Tests\Api\TestCase;

class UserAdminTest extends TestCase
{
    public function shouldSuspendUser()
    {
        $expectedArray = [];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/users/l3l0/suspended')
            ->will($this->returnValue($expectedArray));
        $this->assertEquals($expectedArray, $api->suspend('l3l0'));
    }

    public function shouldUnsuspendUser()
    {
        $expectedArray = [];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/users/l3l0/suspended')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->unsuspend('l3l0'));
    }

    protected function getApiClass(): string
    {
        return \Github\Api\Enterprise\UserAdmin::class;
    }
}
