<?php

namespace Github\Tests\Api;

class MembershipsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetMemberships()
    {
        $expectedValue = [
            [
                'organization' => [
                    'login' => 'octocat',
                    'id'    => 1,
                ],
                'user'         => [
                    'login' => 'defunkt',
                    'id'    => 3,
                ],
            ],
            [
                'organization' => [
                    'login' => 'invitocat',
                    'id'    => 2,
                ],
                'user'         => [
                    'login' => 'defunkt',
                    'id'    => 3,
                ],
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/memberships/orgs')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all());
    }

    /**
     * @test
     */
    public function shouldGetMembershipsForOrganization()
    {
        $expectedValue = [
            'organization' => [
                'login' => 'invitocat',
                'id'    => 2,
            ],
            'user'         => [
                'login' => 'defunkt',
                'id'    => 3,
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/memberships/orgs/invitocat')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->organization('invitocat'));
    }

    /**
     * @test
     */
    public function shouldEditMembershipsForOrganization()
    {
        $expectedValue = [
            'state' => 'active',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/user/memberships/orgs/invitocat')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->edit('invitocat'));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\CurrentUser\Memberships::class;
    }
}
