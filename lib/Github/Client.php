<?php

namespace Github;

use Github\Api\ApiInterface;
use Github\Exception\InvalidArgumentException;
use Github\Exception\BadMethodCallException;
use Github\HttpClient\Plugin\Authentication;
use Github\HttpClient\Plugin\GithubExceptionThrower;
use Github\HttpClient\Plugin\History;
use Github\HttpClient\Plugin\PathPrepend;
use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\StreamFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\MessageFactory;
use Http\Message\SteamFactory;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Simple yet very cool PHP GitHub client.
 *
 * @method Api\CurrentUser currentUser()
 * @method Api\CurrentUser me()
 * @method Api\Enterprise ent()
 * @method Api\Enterprise enterprise()
 * @method Api\GitData git()
 * @method Api\GitData gitData()
 * @method Api\Gists gist()
 * @method Api\Gists gists()
 * @method Api\Issue issue()
 * @method Api\Issue issues()
 * @method Api\Markdown markdown()
 * @method Api\Notification notification()
 * @method Api\Notification notifications()
 * @method Api\Organization organization()
 * @method Api\Organization organizations()
 * @method Api\PullRequest pr()
 * @method Api\PullRequest pullRequest()
 * @method Api\PullRequest pullRequests()
 * @method Api\RateLimit rateLimit()
 * @method Api\Repo repo()
 * @method Api\Repo repos()
 * @method Api\Repo repository()
 * @method Api\Repo repositories()
 * @method Api\Search search()
 * @method Api\Organization team()
 * @method Api\Organization teams()
 * @method Api\User user()
 * @method Api\User users()
 * @method Api\Authorizations authorization()
 * @method Api\Authorizations authorizations()
 * @method Api\Meta meta()
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 *
 * Website: http://github.com/KnpLabs/php-github-api
 */
class Client
{
    /**
     * Constant for authentication method. Indicates the default, but deprecated
     * login with username and token in URL.
     */
    const AUTH_URL_TOKEN = 'url_token';

    /**
     * Constant for authentication method. Not indicates the new login, but allows
     * usage of unauthenticated rate limited requests for given client_id + client_secret.
     */
    const AUTH_URL_CLIENT_ID = 'url_client_id';

    /**
     * Constant for authentication method. Indicates the new favored login method
     * with username and password via HTTP Authentication.
     */
    const AUTH_HTTP_PASSWORD = 'http_password';

    /**
     * Constant for authentication method. Indicates the new login method with
     * with username and token via HTTP Authentication.
     */
    const AUTH_HTTP_TOKEN = 'http_token';

    /**
     * @var array
     */
    private $options = array(
        'api_version' => 'v3',
    );

    /**
     * The object that sends HTTP messages
     *
     * @var HttpClient
     */
    private $httpClient;

    /**
     * A HTTP client with all our plugins
     *
     * @var PluginClient
     */
    private $pluginClient;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var StreamFactory
     */
    private $streamFactory;

    /**
     * @var Plugin[]
     */
    private $plugins = [];

    /**
     * True if we should create a new Plugin client at next request.
     * @var bool
     */
    private $httpClientModified = true;

    /**
     * Http headers
     * @var array
     */
    private $headers = [];

    /**
     * @var History
     */
    private $responseHistory;

    /**
     * Instantiate a new GitHub client.
     *
     * @param HttpClient|null $httpClient
     */
    public function __construct(HttpClient $httpClient = null)
    {
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->messageFactory = MessageFactoryDiscovery::find();
        $this->streamFactory = StreamFactoryDiscovery::find();

        $this->responseHistory = new History();
        $this->addPlugin(new GithubExceptionThrower());
        $this->addPlugin(new Plugin\HistoryPlugin($this->responseHistory));
        $this->addPlugin(new Plugin\RedirectPlugin());
        $this->addPlugin(new Plugin\AddHostPlugin(UriFactoryDiscovery::find()->createUri('https://api.github.com/')));
        $this->addPlugin(new Plugin\HeaderDefaultsPlugin(array(
            'User-Agent'  => 'php-github-api (http://github.com/KnpLabs/php-github-api)',
        )));
        // Add standard headers.
        $this->clearHeaders();
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return ApiInterface
     */
    public function api($name)
    {
        switch ($name) {
            case 'me':
            case 'current_user':
            case 'currentUser':
                $api = new Api\CurrentUser($this);
                break;

            case 'deployment':
            case 'deployments':
                $api = new Api\Deployment($this);
                break;

            case 'ent':
            case 'enterprise':
                $api = new Api\Enterprise($this);
                break;

            case 'git':
            case 'git_data':
            case 'gitData':
                $api = new Api\GitData($this);
                break;

            case 'gist':
            case 'gists':
                $api = new Api\Gists($this);
                break;

            case 'issue':
            case 'issues':
                $api = new Api\Issue($this);
                break;

            case 'markdown':
                $api = new Api\Markdown($this);
                break;

            case 'notification':
            case 'notifications':
                $api = new Api\Notification($this);
                break;

            case 'organization':
            case 'organizations':
                $api = new Api\Organization($this);
                break;

            case 'pr':
            case 'pullRequest':
            case 'pull_request':
            case 'pullRequests':
            case 'pull_requests':
                $api = new Api\PullRequest($this);
                break;

            case 'rateLimit':
            case 'rate_limit':
                $api = new Api\RateLimit($this);
                break;

            case 'repo':
            case 'repos':
            case 'repository':
            case 'repositories':
                $api = new Api\Repo($this);
                break;

            case 'search':
                $api = new Api\Search($this);
                break;

            case 'team':
            case 'teams':
                $api = new Api\Organization\Teams($this);
                break;

            case 'user':
            case 'users':
                $api = new Api\User($this);
                break;

            case 'authorization':
            case 'authorizations':
                $api = new Api\Authorizations($this);
                break;

            case 'meta':
                $api = new Api\Meta($this);
                break;

            default:
                throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }

        return $api;
    }

    /**
     * Authenticate a user for all next requests.
     *
     * @param string      $tokenOrLogin GitHub private token/username/client ID
     * @param null|string $password     GitHub password/secret (optionally can contain $authMethod)
     * @param null|string $authMethod   One of the AUTH_* class constants
     *
     * @throws InvalidArgumentException If no authentication method was given
     */
    public function authenticate($tokenOrLogin, $password = null, $authMethod = null)
    {
        if (null === $password && null === $authMethod) {
            throw new InvalidArgumentException('You need to specify authentication method!');
        }

        if (null === $authMethod && in_array($password, array(self::AUTH_URL_TOKEN, self::AUTH_URL_CLIENT_ID, self::AUTH_HTTP_PASSWORD, self::AUTH_HTTP_TOKEN))) {
            $authMethod = $password;
            $password   = null;
        }

        if (null === $authMethod) {
            $authMethod = self::AUTH_HTTP_PASSWORD;
        }

        $this->removePlugin(Authentication::class);
        $this->addPlugin(new Authentication($tokenOrLogin, $password, $authMethod));
    }

    /**
     * Sets the URL of your GitHub Enterprise instance.
     *
     * @param string $enterpriseUrl URL of the API in the form of http(s)://hostname
     */
    public function setEnterpriseUrl($enterpriseUrl)
    {
        $this->removePlugin(Plugin\AddHostPlugin::class);
        $this->removePlugin(PathPrepend::class);

        $this->addPlugin(new Plugin\AddHostPlugin(UriFactoryDiscovery::find()->createUri($enterpriseUrl)));
        $this->addPlugin(new PathPrepend(sprintf('/api/%s/', $this->getOption('api_version'))));
    }

    /**
     * Add a new plugin to the chain
     *
     * @param Plugin $plugin
     */
    public function addPlugin(Plugin $plugin)
    {
        $this->plugins[] = $plugin;
        $this->httpClientModified = true;
    }

    /**
     * Remove a plugin by its fully qualified class name (FQCN).
     *
     * @param string $fqcn
     */
    public function removePlugin($fqcn)
    {
        foreach ($this->plugins as $idx => $plugin) {
            if ($plugin instanceof $fqcn) {
                unset($this->plugins[$idx]);
                $this->httpClientModified = true;
            }
        }
    }

    /**
     * @return HttpMethodsClient
     */
    public function getHttpClient()
    {
        if ($this->httpClientModified) {
            $this->httpClientModified = false;
            $this->pluginClient = new HttpMethodsClient(
                new PluginClient($this->httpClient, $this->plugins),
                $this->messageFactory
            );
        }

        return $this->pluginClient;
    }

    /**
     * @param HttpClient $httpClient
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClientModified = true;
        $this->httpClient = $httpClient;
    }

    /**
     * Clears used headers.
     */
    public function clearHeaders()
    {
        $this->headers = array(
            'Accept' => sprintf('application/vnd.github.%s+json', $this->options['api_version']),
        );

        $this->removePlugin(Plugin\HeaderAppendPlugin::class);
        $this->addPlugin(new Plugin\HeaderAppendPlugin($this->headers));
    }

    /**
     * @param array $headers
     */
    public function addHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);

        $this->removePlugin(Plugin\HeaderAppendPlugin::class);
        $this->addPlugin(new Plugin\HeaderAppendPlugin($this->headers));
    }

    /**
     * Add a cache plugin to cache responses locally.
     * @param CacheItemPoolInterface $cache
     */
    public function addCache(CacheItemPoolInterface $cachePool)
    {
        $this->removeCache();
        $this->addPlugin(new Plugin\CachePlugin($cachePool, $this->streamFactory));
    }

    /**
     * Remove the cache plugin
     */
    public function removeCache()
    {
        $this->removePlugin(Plugin\CachePlugin::class);
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return mixed
     */
    public function getOption($name)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
        }

        return $this->options[$name];
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws InvalidArgumentException
     * @throws InvalidArgumentException
     */
    public function setOption($name, $value)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
        }

        if ($name === 'api_version') {
            $this->addHeaders([
                'Accept' => sprintf('application/vnd.github.%s+json', $value),
            ]);
        }

        $this->options[$name] = $value;
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return ApiInterface
     */
    public function __call($name, $args)
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name));
        }
    }

    /**
     *
     * @return null|\Psr\Http\Message\ResponseInterface
     */
    public function getLastResponse()
    {
        return $this->responseHistory->getLastResponse();
    }
}
