<?php

namespace Github;

use Buzz\Client\Curl;
use Buzz\Client\ClientInterface;

use Github\Api\ApiInterface;
use Github\Exception\InvalidArgumentException;
use Github\HttpClient\HttpClient;
use Github\HttpClient\HttpClientInterface;
use Github\HttpClient\Listener\AuthListener;

/**
 * Simple yet very cool PHP GitHub client
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
     * usage of unauthenticated rate limited requests for given client_id + client_secret
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
        'base_url'    => 'https://api.github.com/',

        'user_agent'  => 'php-github-api (http://github.com/KnpLabs/php-github-api)',
        'timeout'     => 10,

        'api_limit'   => 5000,
        'api_version' => 'beta',

        'cache_dir'   => null
    );

    /**
     * The Buzz instance used to communicate with GitHub
     *
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Instantiate a new GitHub client
     *
     * @param null|HttpClientInterface $httpClient Github http client
     */
    public function __construct(HttpClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient ?: new HttpClient($this->options);
    }

    /**
     * @param string $name
     *
     * @return ApiInterface
     *
     * @throws InvalidArgumentException
     */
    public function api($name)
    {
        switch ($name) {
            case 'me':
            case 'current_user':
                $api = new Api\CurrentUser($this);
                break;

            case 'git':
            case 'git_data':
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

            case 'organization':
            case 'organizations':
                $api = new Api\Organization($this);
                break;

            case 'pr':
            case 'pull_request':
            case 'pull_requests':
                $api = new Api\PullRequest($this);
                break;

            case 'repo':
            case 'repos':
            case 'repository':
            case 'repositories':
                $api = new Api\Repo($this);
                break;

            case 'user':
            case 'users':
                $api = new Api\User($this);
                break;

            default:
                throw new InvalidArgumentException();
        }

        return $api;
    }

    /**
     * Authenticate a user for all next requests
     *
     * @param string      $tokenOrLogin  GitHub private token/username/client ID
     * @param null|string $password      GitHub password/secret (optionally can contain $authMethod)
     * @param null|string $authMethod    One of the AUTH_* class constants
     *
     * @throws InvalidArgumentException  If no authentication method was given
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

        $this->httpClient->addListener(
            new AuthListener(
                $authMethod,
                array(
                    'tokenOrLogin' => $tokenOrLogin,
                    'password'     => $password
                )
            )
        );
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param HttpClientInterface $httpClient
     */
    public function setHttpClient(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Clears used headers
     */
    public function clearHeaders()
    {
        $this->httpClient->clearHeaders();
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->httpClient->setHeaders($headers);
    }

    /**
     * @param string $name
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
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

        if ('api_version' == $name && !in_array($value, array('v3', 'beta'))) {
            throw new InvalidArgumentException(sprintf('Invalid API version ("%s"), valid are: %s', $name, implode(', ', array('v3', 'beta'))));
        }

        $this->options[$name] = $value;
    }
}
