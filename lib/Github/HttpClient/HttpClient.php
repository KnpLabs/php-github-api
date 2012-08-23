<?php

namespace Github\HttpClient;

use Buzz\Browser;
use Buzz\Client\Curl;
use Buzz\Message\MessageInterface;

use Github\Exception\ApiLimitExceedException;
use Github\HttpClient\Listener\AuthListener;

/**
 * Performs requests on GitHub API. API documentation should be self-explanatory.
 *
 * @author Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class HttpClient implements HttpClientInterface
{
    /**
     * @var integer
     */
    public $remainingCalls;

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
     * @var array
     */
    private $lastResponse;

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

    }

    /**
     * {@inheritDoc}
     */
    public function authenticate()
    {
        $this->browser->addListener(
            new AuthListener(
                $this->options['auth_method'],
                array('login' => $this->options['login'], 'password' => $this->options['password'], 'token' => $this->options['token'])
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;

        return $this;
    }

    /**
     * @return null|array
     */
    public function getPagination()
    {
        if (null === $this->lastResponse) {
            return null;
        }

        return $this->lastResponse['pagination'];
    }

    /**
     * {@inheritDoc}
     */
    public function get($path, array $parameters = array(), array $options = array())
    {
        if (0 < count($parameters)) {
            $path .= (false === strpos($path, '?') ? '?' : '&').http_build_query($parameters, '', '&');
        }

        return $this->request($path, array(), 'GET', $options);
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
        $this->lastResponse = $this->doRequest($url, $parameters, $httpMethod, $options);

        return $this->decodeResponse($this->lastResponse['response']);
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
            'pagination'   => $this->decodePagination($response),
            'errorNumber'  => '',
            'errorMessage' => ''
        );
    }

    /**
     * @param MessageInterface $response
     *
     * @return array|null
     */
    protected function decodePagination(MessageInterface $response)
    {
        $header = $response->getHeader('Link');
        if (empty($header)) {
            return null;
        }

        $pagination = array();
        foreach (explode(',', $header) as $link) {
            preg_match('/<(.*)>; rel="(.*)"/i', trim($link, ','), $match);

            if (3 === count($match)) {
                $pagination[$match[2]] = $match[1];
            }
        }

        return $pagination;
    }

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    protected function checkApiLimit(MessageInterface $response)
    {
        $this->remainingCalls = $response->getHeader('X-RateLimit-Remaining');

        if (null !== $this->remainingCalls && 1 > $this->remainingCalls) {
            throw new ApiLimitExceedException($this->options['api_limit']);
        }
    }
}
