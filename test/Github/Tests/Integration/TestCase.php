<?php

namespace Github\Tests\Integration;

use Github\Client;
use Github\Exception\ApiLimitExceedException;
use Github\Exception\RuntimeException;
use Symfony\Component\Dotenv\Dotenv;

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
        $this->checkAuthentication($client);
        $this->client = $client;
    }

    protected function authenticate(Client $client, $accountNumber = 1)
    {
        $envFilePath = __DIR__.'/../../../../.env';
        if (!file_exists($envFilePath)){
            $this->markTestSkipped('Missing .env file');
            return;
        }

        (new Dotenv())->load($envFilePath);
        $method = getenv('GITHUB_AUTH_METHOD');
        if (!getenv('GITHUB_AUTH_METHOD')) {
            $this->markTestSkipped('Missing authentication settings');
            return;
        }
        switch ($method) {
            case 'token':
                $client->authenticate($method, getenv('GITHUB_TOKEN_'.$accountNumber));
                break;
            case 'login':
                $client->authenticate($method, getenv('GITHUB_USERNAME_'.$accountNumber),
                    getenv('GITHUB_PASSWORD'.$accountNumber));
                break;
            default:
                $this->markTestSkipped('Invalid authentication method.');
        }
        $this->checkAuthentication($client);
    }

    protected function checkAuthentication(Client $client){
        try {
            $client->me()->show();
        } catch (ApiLimitExceedException $e) {
            $this->markTestSkipped('API limit reached. Skipping to prevent unnecessary failure.');
        } catch (RuntimeException $e) {
            if ('Requires authentication' == $e->getMessage()) {
                $this->markTestSkipped('Test requires authentication. Skipping to prevent unnecessary failure.');
            }
        }
    }
}
