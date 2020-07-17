<?php

namespace Github\Tests\Api\Miscellaneous;

use Github\Api\Miscellaneous\CodeOfConduct;
use Github\Tests\Api\TestCase;

class CodeOfConductTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllCodeOfConducts()
    {
        $expectedArray = [
            ['name' => 'CoC1'],
            ['name' => 'CoC2'],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/codes_of_conduct')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all());
    }

    /**
     * @test
     */
    public function shouldGetSingleCodeOfConducts()
    {
        $expectedArray = [
            'name' => 'CoC',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/codes_of_conduct/contributor_covenant')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('contributor_covenant'));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return CodeOfConduct::class;
    }
}
