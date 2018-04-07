<?php

namespace Github\Tests\Integration;

use Dotenv\Dotenv;
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
        $this->auth($client);

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

    protected function auth(Client &$client, $accountNumber = 1)
    {
        try {
            (new Dotenv(__DIR__ . "/../../../../"))->load();
            $method = getenv('GITHUB_AUTH_METHOD');
            if (!getenv('GITHUB_AUTH_METHOD')) {
                return;
            }
            switch ($method) {
                case 'token':
                    $client->authenticate($method, getenv('GITHUB_TOKEN_'.$accountNumber));
                    break;
                case 'login':
                    $client->authenticate($method, getenv('GITHUB_USERNAME_'.$accountNumber),
                        getenv('GITHUB_PASSWORD_{$accountNumber}'));
                    break;
            }
        } catch (\Exception $e) {
            error_log('Unable to authenticated', 0);
        }
    }
}
