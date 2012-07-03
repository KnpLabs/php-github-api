<?php

namespace Github\HttpClient;

use Buzz\Browser;
use Buzz\Client\Curl;
use Buzz\Message\MessageInterface;

use Github\HttpClient\Listener\AuthListener;

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
        'url'         => 'https://api.github.com/:path',
        'user_agent'  => 'php-github-api (http://github.com/KnpLabs/php-github-api)',
        'http_port'   => 443,
        'timeout'     => 10,

        'api_limit'   => 5000,

        'auth_method' => null,

        'login'       => null,
        'password'    => null,
        'token'       => null,
    );

    /**
     * @var array
     */
    protected static $history = array();

    /**
     * @var array
     */
    protected $headers = array();

    /**
     * @var Browser
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
        $this->browser = $browser ?: new Browser(new Curl());

        $this->browser->getClient()->setTimeout($this->options['timeout']);
        $this->browser->getClient()->setVerifyPeer(false);

        if (null !== $this->options['login'] || null !== $this->options['token']) {
            if (null !== $this->options['token']) {
                $options = array($this->options['token']);
            } else {
                $options = array($this->options['login'], $this->options['password']);
            }

            $this->browser->addListener(
                new AuthListener($this->options['auth_method'], $options)
            );
        }
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
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
     * {@inheritDoc}
     */
    public function get($path, array $parameters = array(), array $options = array())
    {
        return $this->request($path, $parameters, 'GET', $options);
    }

    /**
     * {@inheritDoc}
     */
    public function post($path, array $parameters = array(), array $options = array())
    {
        return $this->request($path, $parameters, 'POST', $options);
    }

    /**
     * {@inheritDoc}
     */
    public function patch($path, array $parameters = array(), array $options = array())
    {
        return $this->request($path, $parameters, 'PATCH', $options);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($path, array $parameters = array(), array $options = array())
    {
        return $this->request($path, $parameters, 'DELETE', $options);
    }

    /**
     * {@inheritDoc}
     */
    public function put($path, array $options = array())
    {
        return $this->request($path, array(), 'PUT', $options);
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

        return $this->decodeResponse($response['response']);
    }

    /**
     * Send a request to the server, receive a response
     *
     * @param  string   $url           Request url
     * @param  array    $parameters    Parameters
     * @param  string   $httpMethod    HTTP method to use
     * @param  array    $options       Request options
     *
     * @return array    HTTP response
     */
    protected function doRequest($url, array $parameters = array(), $httpMethod = 'GET', array $options = array())
    {
        $response = $this->browser->call($url, $httpMethod, $this->headers, json_encode($parameters));

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
            return $response;
        }

        return $content;
    }

    /**
     * Report to user he reached his GitHub API limit.
     *
     * @param MessageInterface $response
     *
     * @throws \RuntimeException
     */
    protected function checkApiLimit(MessageInterface $response)
    {
        $limit = $response->getHeader('X-RateLimit-Remaining');

        if (null !== $limit && 1 > $limit) {
            throw new \RuntimeException('You have reached GitHub hour limit! Actual limit is: '. $this->options['api_limit']);
        }
    }
}
