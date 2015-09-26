<?php

namespace Github\Tests\Functional;

/**
 * @group functional
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

}
