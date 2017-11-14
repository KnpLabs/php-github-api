<?php declare(strict_types=1);

namespace Github\Tests\Api;

class MembershipsTest extends TestCase
{
    public function shouldGetMemberships()
    {
        $expectedValue = array(
            array(
                'organization' => array(
                    'login' => 'octocat',
                    'id'    => 1,
                ),
                'user'         => array(
                    'login' => 'defunkt',
                    'id'    => 3,
                ),
            ),
            array(
                'organization' => array(
                    'login' => 'invitocat',
                    'id'    => 2,
                ),
                'user'         => array(
                    'login' => 'defunkt',
                    'id'    => 3,
                ),
            ),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/memberships/orgs')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all());
    }

    public function shouldGetMembershipsForOrganization()
    {
        $expectedValue = array(
            'organization' => array(
                'login' => 'invitocat',
                'id'    => 2,
            ),
            'user'         => array(
                'login' => 'defunkt',
                'id'    => 3,
            ),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/memberships/orgs/invitocat')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->organization('invitocat'));
    }

    public function shouldEditMembershipsForOrganization()
    {
        $expectedValue = array(
            'state' => 'active',
        );

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
    protected function getApiClass(): string
    {
        return \Github\Api\CurrentUser\Memberships::class;
    }
}
