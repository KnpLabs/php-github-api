<?php declare(strict_types=1);

namespace Github\Api;

/**
 * Get rate limits
 *
 * @link   https://developer.github.com/v3/rate_limit/
 * @author Jeff Finley <quickliketurtle@gmail.com>
 */
class RateLimit extends AbstractApi
{
    /**
     * Get rate limits
     */
    public function getRateLimits(): array
    {
        return $this->get('/rate_limit');
    }

    /**
     * Get core rate limit
     *
     * @return integer
     */
    public function getCoreLimit(): int
    {
        $response = $this->getRateLimits();

        return $response['resources']['core']['limit'];
    }

    /**
     * Get search rate limit
     *
     * @return integer
     */
    public function getSearchLimit(): int
    {
        $response = $this->getRateLimits();

        return $response['resources']['search']['limit'];
    }
}
