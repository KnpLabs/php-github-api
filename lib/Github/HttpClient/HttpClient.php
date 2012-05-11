<?php

namespace Github\HttpClient;

use Buzz\Browser;
use Buzz\Message\Response;

/**
 * Performs requests on GitHub API. API documentation should be self-explanatory.
 *
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
class HttpClient implements HttpClientInterface
{
    /**
     * The http client options
     * @var array
     */
    protected $options = array(
        'url'        => 'https://github.com/api/v3/:path/:format',
        'user_agent' => 'php-github-api (http://github.com/KnpLabs/php-github-api)',
        'http_port'  => 443,
        'timeout'    => 10,

        'api_limit'  => 5000,

        'login'      => null,
        'password'   => null,
        'token'      => null,
    );

    /**
     * @var array
     */
    protected static $history = array();

    /**
     * @var Buzz\Browser
     */
    protected $browser;

    /**
     * Instantiated a new http client
     *
     * @param array        $options Http client options
     * @param null|Browser $browser Buzz client
     */
    public function __construct(array $options = array(), Browser $browser = null)
    {
        $this->options = array_merge($this->options, $options);
        $this->browser = $browser ?: new Browser();

        $this->browser->getClient()->setTimeout($this->options['timeout']);
        $this->browser->getClient()->setVerifyPeer(false);

        if ($this->options['login']) {
            $this->browser->addListener(
                new Listener\AuthListener(
                    $this->options['auth_method'],
                    array($this->options['login'], $this->options['password'])
                )
            );
        }
    }

    /**
     * Change an option value.
     *
     * @param string $name   The option name
     * @param mixed  $value  The value
     *
     * @return self The current object instance
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;

        return $this;
    }

    /**
     * {@inheridoc}
     */
    public function get($path, array $parameters = array(), array $options = array())
    {
        return $this->request($path, $parameters, 'GET', $options);
    }

    /**
     * {@inheridoc}
     */
    public function post($path, array $parameters = array(), array $options = array())
    {
        return $this->request($path, $parameters, 'POST', $options);
    }

    /**
     * Send a request to the server, receive a response,
     * decode the response and returns an associative array
     *
     * @param  string   $path       Request API path
     * @param  array    $parameters Parameters
     * @param  string   $httpMethod HTTP method to use
     * @param  array    $options    Request options
     *
     * @return array                Data
     */
    public function request($path, array $parameters = array(), $httpMethod = 'GET', array $options = array())
    {
        $options = array_merge($this->options, $options);

        // create full url
        $url = strtr($options['url'], array(
            ':path' => trim($path, '/')
        ));

        // get encoded response
        $response = $this->doRequest($url, $parameters, $httpMethod, $options);

        // decode response
        $response = $this->decodeResponse($response);

        return $response;
    }

    /**
     * Send a request to the server, receive a response
     *
     * @param  string   $url           Request url
     * @param  array    $parameters    Parameters
     * @param  string   $httpMethod    HTTP method to use
     * @param  array    $options       Request options
     *
     * @return string   HTTP response
     */
    protected function doRequest($url, array $parameters = array(), $httpMethod = 'GET', array $options = array())
    {
        $response = $this->browser->call($url, $httpMethod);

        $this->checkApiLimit($response);

        return array(
            'response'     => $response->getContent(),
            'headers'      => $response->getHeaders(),
            'errorNumber'  => '',
            'errorMessage' => ''
        );
    }

    /**
     * Get a JSON response and transform it to a PHP array
     *
     * @param  string $response  The response
     *
     * @return array  The content of response
     *
     * @throws \RuntimeException
     */
    protected function decodeResponse($response)
    {
        $content = json_decode($response, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException('Response was not valid json, error: '.json_last_error());
        }

        return $content;
    }

    /**
     * Report to user he reached his GitHub API limit.
     *
     * @param Response $response
     *
     * @throws \RuntimeException
     */
    protected function checkApiLimit(Response $response)
    {
        $limit = $response->getHeader('X-RateLimit-Remaining');

        if (null !== $limit && 1 < $limit) {
            throw new \RuntimeException('You have reached GitHub hour limit! Actual limit is: '. $this->options['api_limit']);
        }
    }
}
