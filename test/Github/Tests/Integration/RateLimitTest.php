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
        $this->assertArrayHasKey('resources', $response);
        $this->assertSame(['core' => ['limit' => 60]], $response['resources']);
    }

    /**
     * @test
     */
    public function shouldRetrieveRateLimitsAndReturnLimitInstances()
    {
        $response = $this->client->api('rate_limit')->getLimits();

        $this->assertIsArray($response);
        $this->assertContainsOnlyInstancesOf(RateLimitResource::class, $response);
        $this->assertEquals(60, $response->getLimit('core')->getLimit());
    }
}
