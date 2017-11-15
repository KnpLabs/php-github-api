<?php declare(strict_types=1);

namespace Github\Tests\Api;

class RateLimitTest extends TestCase
{
    public function shouldReturnRateLimitArray()
    {
        $expectedArray = [
            'resources' => [
                'core' => [
                    'limit' => 5000,
                    'remaining' => 4999,
                    'reset' => 1372700873
                ],
                'search' => [
                    'limit' => 30,
                    'remaining' => 18,
                    'reset' => 1372697452
                ]
            ]
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/rate_limit')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->getRateLimits());
    }

    protected function getApiClass(): string
    {
        return \Github\Api\RateLimit::class;
    }
}
