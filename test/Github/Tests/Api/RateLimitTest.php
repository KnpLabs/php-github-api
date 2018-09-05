<?php

namespace Github\Tests\Api;

use Github\Api\RateLimit;

class RateLimitTest extends TestCase
{
    /**
     * Used for common assertions in each test.
     *
     * @var array
     */
    protected $expectedArray = [
        'resources' => [
            'core' => [
                'limit' => 5000,
                'remaining' => 4999,
                'reset' => 1372700873,
            ],
            'search' => [
                'limit' => 30,
                'remaining' => 18,
                'reset' => 1372697452,
            ],
            'graphql' => [
                'limit' => 5000,
                'remaining' => 4030,
                'reset' => 1372697452,
            ],
        ],
    ];

    /**
     * @var RateLimit
     */
    protected $api;

    /**
     * Used to construct common expectations for the API input data in each unit test.
     *
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->api = $this->getApiMock();
        $this->api->expects($this->once())
            ->method('get')
            ->with('/rate_limit')
            ->will($this->returnValue($this->expectedArray));
    }

    /**
     * @test
     */
    public function shouldReturnRateLimitArray()
    {
        $this->assertSame($this->expectedArray, $this->api->getRateLimits());
    }

    /**
     * @test
     */
    public function shouldReturnArrayOfLimitInstances()
    {
        $this->assertContainsOnlyInstancesOf(RateLimit\RateLimitResource::class, $this->api->getResources());
    }

    /**
     * @test
     */
    public function shouldReturnRemainingGraphQLRequests()
    {
        $this->assertSame(4030, $this->api->getResource('graphql')->getRemaining());
    }

    /**
     * @test
     */
    public function shouldReturnResetForSearch()
    {
        $this->assertSame(1372697452, $this->api->getResource('search')->getReset());
    }

    /**
     * @test
     */
    public function shouldReturnFalseWhenResourceIsNotFound()
    {
        $this->assertFalse($this->api->getResource('non-exitent'));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\RateLimit::class;
    }
}
