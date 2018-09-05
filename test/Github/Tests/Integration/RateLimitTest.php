<?php

namespace Github\Tests\Integration;

use Github\Api\RateLimit\RateLimitResource;

/**
 * @group integration
 */
class RateLimitTest extends TestCase
{
    /**
     * @test
     */
    public function shouldRetrievedRateLimits()
    {
        $response = $this->client->api('rate_limit')->getRateLimits();

        $this->assertArrayHasKey('resources', $response);
        $this->assertArraySubset(['resources' => ['core' => ['limit' => 60]]], $response);
    }

    /**
     * @test
     */
    public function shouldRetrieveRateLimitsAndReturnLimitInstances()
    {
        $response = $this->client->api('rate_limit')->getLimits();

        $this->assertInternalType('array', $response);
        $this->assertContainsOnlyInstancesOf(RateLimitResource::class, $response);
        $this->assertEquals(60, $response->getLimit('core')->getLimit());
    }
}
