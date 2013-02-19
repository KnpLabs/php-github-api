<?php

namespace Github\Tests\Functional;

use Github\Client;
use Github\Exception\ApiLimitExceedException;
use Github\Exception\RuntimeException;

/**
 * @group functional
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    protected $client;

    public function setUp()
    {
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
