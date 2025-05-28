<?php

namespace ArgoCD\Tests\Integration;

use ArgoCD\Client;
use ArgoCD\Exception\ApiLimitExceedException;
use ArgoCD\Exception\RuntimeException;

/**
 * @group integration
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @before
     */
    public function initClient()
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
