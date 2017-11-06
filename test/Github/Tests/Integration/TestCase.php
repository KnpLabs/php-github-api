<?php

namespace Github\Tests\Integration;

use Github\Client;
use Github\Exception\ApiLimitExceedException;
use Github\Exception\RuntimeException;

/**
 * @group integration
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Client
     */
    protected $client;

    public function setUp()
    {
        // You have to specify authentication here to run full suite
        $client = new Client();

        try {
            $client->api('current_user')->show();
        } catch (ApiLimitExceedException $e) {
            $this->markTestSkipped('API limit reached. Skipping to prevent unnecessary failure.');
        } catch (RuntimeException $e) {
            if ('Requires authentication' == $e->getMessage()) {
                $this->markTestSkipped('Test requires authentication. Skipping to prevent unnecessary failure.');
            }
        }

        $this->client = $client;
    }
}
