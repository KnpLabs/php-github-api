<?php

namespace Github;

use Github\Api\ApiInterface;
use Github\HttpClient\HttpClientInterface;
use Github\HttpClient\HttpClient;

/**
 * Simple yet very cool PHP Github client
 *
 * @author Thibault Duplessis <thibault.duplessis at gmail dot com>
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
     * The httpClient instance used to communicate with GitHub
     *
     * @var HttpClientInterface
     */
    private $httpClient = null;

    /**
     * The list of loaded API instances
     *
     * @var array
     */
    private $apis = array();

    /**
     * HTTP Headers
     *
     * @var array
     */
    private $headers = array();

    /**
     * Instantiate a new GitHub client
     *
     * @param HttpClientInterface $httpClient custom http client
     */
    public function __construct(HttpClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient ?: new HttpClient();
    }

    /**
     * Authenticate a user for all next requests
     *
     * @param string      $login  GitHub username
     * @param string      $secret GitHub private token or Github password if $method == AUTH_HTTP_PASSWORD
     * @param null|string $method One of the AUTH_* class constants
     */
    public function authenticate($login, $secret = null, $method = null)
    {
        $this->getHttpClient()->setOption('auth_method', $method);

        if ($method === self::AUTH_HTTP_PASSWORD || $method === self::AUTH_URL_CLIENT_ID) {
            $this
                ->getHttpClient()
                ->setOption('login', $login)
                ->setOption('password', $secret)
            ;
        } else {
            $this->getHttpClient()->setOption('token', $secret);
        }

        $this->getHttpClient()->authenticate();
    }

    /**
     * Call any path, GET method
     * Ex: $api->get('repos/show/my-username/my-repo')
     *
     * @param   string  $path            the GitHub path
     * @param   array   $parameters       GET parameters
     * @param   array   $requestOptions   reconfigure the request
     * @return  array                     data returned
     */
    public function get($path, array $parameters = array(), $requestOptions = array())
    {
        return $this->getHttpClient()->get($path, $parameters, $requestOptions);
    }

    /**
     * Call any path, POST method
     * Ex: $api->post('repos/show/my-username', array('email' => 'my-new-email@provider.org'))
     *
     * @param   string  $path             the GitHub path
     * @param   array   $parameters       POST parameters
     * @param   array   $requestOptions   reconfigure the request
     * @return  array                     data returned
     */
    public function post($path, array $parameters = array(), $requestOptions = array())
    {
        return $this->getHttpClient()->post($path, $parameters, $requestOptions);
    }

    /**
     * Call any path, PUT method
     *
     * @param   string  $path            the GitHub path
     * @param   array   $requestOptions   reconfigure the request
     * @return  array                     data returned
     */
    public function put($path, $requestOptions = array())
    {
        return $this->getHttpClient()->put($path, $requestOptions);
    }

    /**
     * Call any path, PATCH method
     *
     * @param   string  $path            the GitHub path
     * @param   array   $parameters       Patch parameters
     * @param   array   $requestOptions   reconfigure the request
     * @return  array                     data returned
     */
    public function patch($path, array $parameters = array(), $requestOptions = array())
    {
        return $this->getHttpClient()->patch($path, $parameters, $requestOptions);
    }

    /**
     * Call any path, DELETE method
     *
     * @param   string  $path            the GitHub path
     * @param   array   $parameters       DELETE parameters
     * @param   array   $requestOptions   reconfigure the request
     * @return  array                     data returned
     */
    public function delete($path, array $parameters = array(), $requestOptions = array())
    {
        return $this->getHttpClient()->delete($path, $parameters, $requestOptions);
    }

    /**
     * Get the http client.
     *
     * @return HttpClientInterface a request instance
     */
    public function getHttpClient()
    {
        $this->httpClient->setHeaders($this->headers);

        return $this->httpClient;
    }

    /**
     * Inject another http client
     *
     * @param HttpClientInterface $httpClient The httpClient instance
     */
    public function setHttpClient(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $name
     *
     * @return ApiInterface
     *
     * @throws \InvalidArgumentException
     */
    public function api($name)
    {
        if (!isset($this->apis[$name])) {
            switch ($name) {
                case 'current_user':
                    $api = new Api\CurrentUser($this);
                    break;

                case 'git_data':
                    $api = new Api\GitData($this);
                    break;

                case 'gists':
                    $api = new Api\Gists($this);
                    break;

                case 'issue':
                    $api = new Api\Issue($this);
                    break;

                case 'markdown':
                    $api = new Api\Markdown($this);
                    break;

                case 'organization':
                    $api = new Api\Organization($this);
                    break;

                case 'pull_request':
                    $api = new Api\PullRequest($this);
                    break;

                case 'repo':
                    $api = new Api\Repo($this);
                    break;

                case 'user':
                    $api = new Api\User($this);
                    break;

                default:
                    throw new \InvalidArgumentException();
            }

            $this->apis[$name] = $api;
        }

        return $this->apis[$name];
    }

    /**
     * @return mixed
     */
    public function getRateLimit()
    {
        return $this->get('rate_limit');
    }

    /**
     * Clears used headers
     */
    public function clearHeaders()
    {
        $this->setHeaders(array());
    }

    /**
     * @param array $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }
}
