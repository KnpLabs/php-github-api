<?php

namespace Github\Tests\Api\Miscellaneous;

use Github\Api\Miscellaneous\Emojis;
use Github\Tests\Api\TestCase;

class EmojisTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllEmojis()
    {
        $expectedArray = [
            '+1' => 'https://github.global.ssl.fastly.net/images/icons/emoji/+1.png?v5',
            '-1' => 'https://github.global.ssl.fastly.net/images/icons/emoji/-1.png?v5',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/emojis')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all());
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return Emojis::class;
    }
}
