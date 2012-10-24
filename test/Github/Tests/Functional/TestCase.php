<?php

namespace Github\Tests\Functional;

use Github\Client;
use Github\Exception\ApiLimitExceedException;

class TestCase
{
    protected $client;

    public function setUp()
    {
        $client = new Client();

        try {
            $client->api('current_user')->show();
        } catch (ApiLimitExceedException $e) {
            $this->markTestSkipped('API limit reached. Skipping to prevent unnecessary failure.');
        }

        $this->client = $client;
    }
}
