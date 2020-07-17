<?php

namespace Github\Tests\Api;

class MetaTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetInformationService()
    {
        $expectedArray = [
            'hooks' => [
                '127.0.0.1/32',
            ],
            'git' => [
                '127.0.0.1/32',
            ],
            'verifiable_password_authentication' => true,
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->service());
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Meta::class;
    }
}
