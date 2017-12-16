<?php

namespace Github\Tests\Api\Enterprise;

use Github\Tests\Api\TestCase;

class LicenseTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowLicenseInformation()
    {
        $expectedArray = [
            'seats' => 1400,
            'seats_used' => 1316,
            'seats_available' => 84,
            'kind' => 'standard',
            'days_until_expiration' => 365,
            'expire_at' => '2016/02/06 12:41:52 -0600',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/enterprise/settings/license')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show());
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Enterprise\License::class;
    }
}
