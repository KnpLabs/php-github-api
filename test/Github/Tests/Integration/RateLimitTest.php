<?php declare(strict_types=1);

namespace Github\Tests\Integration;

/**
 * @group integration
 */
class RateLimitTest extends TestCase
{
    public function shouldRetrievedRateLimits()
    {
        $response = $this->client->api('rate_limit')->getRateLimits();

        $this->assertArrayHasKey('resources', $response);
        $this->assertArraySubset(array('resources' => array('core' => array('limit' => 60))), $response);
    }
}
