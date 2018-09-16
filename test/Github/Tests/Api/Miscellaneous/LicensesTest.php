<?php

namespace Github\Tests\Api\Miscellaneous;

use Github\Api\Miscellaneous\Licenses;
use Github\Tests\Api\TestCase;

class LicensesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllLicenses()
    {
        $expectedArray = [
            ['key' => 'mit'],
            ['key' => 'apache-2.0'],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/licenses')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all());
    }

    /**
     * @test
     */
    public function shouldGetSingleLicenses()
    {
        $expectedArray = [
            'key' => 'gpl-2.0',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/licenses/gpl-2.0')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('gpl-2.0'));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return Licenses::class;
    }
}
