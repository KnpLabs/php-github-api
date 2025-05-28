<?php

namespace ArgoCD;

use ArgoCD\Api\AbstractApi;
use ArgoCD\Api\SessionService; // Added for SessionService
use ArgoCD\Exception\BadMethodCallException;
use ArgoCD\Exception\InvalidArgumentException;
use ArgoCD\HttpClient\Builder;
use ArgoCD\HttpClient\Plugin\Authentication;
use ArgoCD\HttpClient\Plugin\ExceptionThrower;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use ArgoCD\HttpClient\Plugin\History;

/**
 * PHP ArgoCD client.
 *
 * @method Api\SessionService     session()
 * @method Api\SessionService     sessionService()
 * @method Api\ApplicationService application()
 * @method Api\ApplicationService applicationService()
 * @method Api\AccountService     account()
 * @method Api\AccountService     accountService()
 */
class Client
{
    /**
     * @var Builder
     */
    private $httpClientBuilder;

    /**
     * @var History
     */
    private $responseHistory;

    /**
     * @var string|null The ArgoCD API Bearer token
     */
    private $token = null;

    /**
     * Instantiate a new ArgoCD client.
     *
     * @param string|null  $serverUrl         The ArgoCD API server URL (e.g., https://your-argocd-server.com)
     * @param Builder|null $httpClientBuilder
     */
    public function __construct(?string $serverUrl = null, ?Builder $httpClientBuilder = null)
    {
        $this->responseHistory = new History();
        $this->httpClientBuilder = $builder = $httpClientBuilder ?? new Builder();

        $builder->addPlugin(new ExceptionThrower());
        $builder->addPlugin(new Plugin\HistoryPlugin($this->responseHistory));
        $builder->addPlugin(new Plugin\RedirectPlugin());

        if (null === $serverUrl) {
            throw new InvalidArgumentException('Server URL is required to instantiate the ArgoCD client.');
        }

        $uri = Psr17FactoryDiscovery::findUriFactory()->createUri($serverUrl);
        $builder->addPlugin(new Plugin\AddHostPlugin($uri));
        $builder->addPlugin(new Plugin\PathPrepend('/api/v1')); 

        $builder->addPlugin(new Plugin\HeaderDefaultsPlugin([
            'User-Agent' => 'argocd-php-client (https://github.com/your-vendor/argocd-php-client)',
            'Accept' => 'application/json',
        ]));
    }

    /**
     * Create a ArgoCD\Client using a HTTP client.
     *
     * @param ClientInterface $httpClient
     * @param string|null     $serverUrl
     * @return Client
     */
    public static function createWithHttpClient(ClientInterface $httpClient, ?string $serverUrl = null): self
    {
        $builder = new Builder($httpClient);
        // Allow serverUrl to be passed here for consistency, or ensure it's set later.
        if ($serverUrl === null) {
            // Or throw an exception if serverUrl is strictly required at this point
            // For now, assuming it can be null and might be set via constructor or setServerUrl
        }
        return new self($serverUrl, $builder); 
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return AbstractApi
     */
    public function api($name): AbstractApi
    {
        switch (strtolower($name)) {
            case 'session':
            case 'sessionservice':
                $api = new Api\SessionService($this);
                break;
            case 'application':
            case 'applicationservice':
                $api = new Api\ApplicationService($this);
                break;
            case 'account':
            case 'accountservice':
                $api = new Api\AccountService($this);
                break;
            default:
                throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }

        return $api;
    }

    /**
     * Authenticate a user for all next requests.
     *
     * @param string      $usernameOrToken ArgoCD username or a pre-existing Bearer token
     * @param string|null $password        ArgoCD password (if username is provided)
     *
     * @throws InvalidArgumentException If username/password authentication fails or token is invalid.
     * @throws \ArgoCD\Exception\RuntimeException For API errors.
     *
     * @return void
     */
    public function authenticate(string $usernameOrToken, ?string $password = null): void
    {
        $this->getHttpClientBuilder()->removePlugin(Authentication::class); // Remove any existing auth plugin

        if ($password !== null) {
            // Username/password authentication
            $sessionService = new SessionService($this);
            $sessionResponse = $sessionService->create($usernameOrToken, $password);
            $this->token = $sessionResponse->getToken();

            if (empty($this->token)) {
                throw new InvalidArgumentException('Authentication failed: Could not retrieve token with the provided username and password.');
            }
        } else {
            // Direct token authentication
            $this->token = $usernameOrToken;
        }

        if (empty($this->token)) {
             throw new InvalidArgumentException('Authentication failed: Token cannot be empty.');
        }

        $this->getHttpClientBuilder()->addPlugin(new Authentication($this->token, AuthMethod::BEARER_TOKEN));
    }
    
    /**
     * Get the currently stored token.
     *
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Sets the URL of your ArgoCD API server instance.
     *
     * @param string $serverUrl URL of the API in the form of http(s)://hostname or http(s)://hostname/api/v1
     *
     * @return void
     */
    public function setServerUrl(string $serverUrl): void
    {
        $builder = $this->getHttpClientBuilder();
        $builder->removePlugin(Plugin\AddHostPlugin::class);
        $builder->removePlugin(Plugin\PathPrepend::class); 

        $uri = Psr17FactoryDiscovery::findUriFactory()->createUri($serverUrl);
        $builder->addPlugin(new Plugin\AddHostPlugin($uri));
        
        if (strpos($serverUrl, '/api/v1') === false) {
            $builder->addPlugin(new Plugin\PathPrepend('/api/v1'));
        }
    }

    /**
     * @param string $name
     * @param array  $args
     *
     * @return AbstractApi
     */
    public function __call($name, $args): AbstractApi
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name));
        }
    }

    /**
     * @return null|ResponseInterface
     */
    public function getLastResponse(): ?ResponseInterface
    {
        return $this->responseHistory->getLastResponse();
    }

    /**
     * @return HttpMethodsClientInterface
     */
    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->getHttpClientBuilder()->getHttpClient();
    }

    /**
     * @return Builder
     */
    protected function getHttpClientBuilder(): Builder
    {
        return $this->httpClientBuilder;
    }
}
