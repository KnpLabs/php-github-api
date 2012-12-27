<?php

namespace Github\Tests\Api\Organization;

use Github\Tests\Api\TestCase;

class MembersTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllOrganizationMembers()
    {
        $expectedValue = array(array('username' => 'l3l0'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('orgs/KnpLabs/members')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldGetPublicOrganizationMembers()
    {
        $expectedValue = array(array('username' => 'l3l0'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('orgs/KnpLabs/public_members')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', true));
    }

    /**
     * @test
     */
    public function shouldCheckIfOrganizationMember()
    {
        $expectedValue = 'response';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('orgs/KnpLabs/public_members/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->check('KnpLabs', 'l3l0'));
    }

    /**
     * @test
     */
    public function shouldRemoveOrganizationMember()
    {
        $expectedValue = 'response';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('orgs/KnpLabs/members/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'l3l0'));
    }

    /**
     * @test
     */
    public function shouldPublicizeOrganizationMembership()
    {
        $expectedValue = 'response';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('orgs/KnpLabs/public_members/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->publicize('KnpLabs', 'l3l0'));
    }

    /**
     * @test
     */
    public function shouldConcealOrganizationMembership()
    {
        $expectedValue = 'response';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('orgs/KnpLabs/public_members/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->conceal('KnpLabs', 'l3l0'));
    }

    /**
     * @test
     */
    public function shouldShowOrganizationMember()
    {
        $expectedValue = array('username' => 'l3l0');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('orgs/KnpLabs/members/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'l3l0'));
    }

    protected function getApiClass()
    {
        return 'Github\Api\Organization\Members';
    }
}
