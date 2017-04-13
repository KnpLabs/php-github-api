<?php

namespace Github\Tests\Api;

class RateLimitTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnRateLimitArray()
    {
        $expectedArray = array(
            'resources' => array(
                'core' => array(
                    'limit' => 5000,
                    'remaining' => 4999,
                    'reset' => 1372700873
                ),
                'search' => array(
                    'limit' => 30,
                    'remaining' => 18,
                    'reset' => 1372697452
                )
            )
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/rate_limit')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->getRateLimits());
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\RateLimit::class;
    }
}
