<?php

namespace Github\HttpClient\Adapter\Guzzle;

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Client;

use Github\Client as GithubClient;
use Github\Exception\RuntimeException;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
use Github\HttpClient\HttpClientInterface;

class HttpClient implements HttpClientInterface
{
    /**
     * @var \Guzzle\Http\ClientInterface
     */
    private $client;
    /**
     * @var array
     */
    protected $options = array(
        'base_url'    => 'https://api.github.com/',

        'user_agent'  => 'php-github-api (http://github.com/KnpLabs/php-github-api)',
        'timeout'     => 10,

        'api_limit'   => 5000,
        'api_version' => 'beta',

        'cache_dir'   => null
    );
    /**
     * @var array
     */
    protected $headers = array();

    private $lastResponse;
    private $lastRequest;

    /**
     * @param array           $options
     * @param ClientInterface $client
     */
    public function __construct(array $options = array(), ClientInterface $client = null)
    {
        $client = $client ?: new Client();

        $client->setBaseUrl($this->options['base_url']);
        $client->setSslVerification(false);

        $opts = $client->getConfig(Client::CURL_OPTIONS);
        $opts[CURLOPT_TIMEOUT] = $this->options['timeout'];

        $client->getConfig()->set(Client::CURL_OPTIONS, $opts);

        $this->options = array_merge($this->options, $options);
        $this->client  = $client;

//        $this->addListener(new ErrorListener($this->options));

        $this->clearHeaders();
    }

    /**
     * {@inheritDoc}
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function clearHeaders()
    {
        $this->headers = array(
            sprintf('Accept: application/vnd.github.%s+json', $this->options['api_version'])
        );
    }

    /**
     * {@inheritDoc}
     */
    public function get($path, array $parameters = array(), array $headers = array())
    {
        if (0 < count($parameters)) {
            $path .= (false === strpos($path, '?') ? '?' : '&').http_build_query($parameters, '', '&');
        }

        return $this->request($path, array(), 'GET', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function post($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'POST', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function patch($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'PATCH', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'DELETE', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function put($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'PUT', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function request($path, array $parameters = array(), $httpMethod = 'GET', array $headers = array())
    {
        $path = trim($path, '/');

        $request = $this->client->createRequest($httpMethod, $path, $headers, json_encode($parameters));

        try {
            $response = $request->send();
        } catch (\Guzzle\Common\Exception\GuzzleException $e) {
            throw new RuntimeException($e->getMessage());
        }

        $this->lastRequest  = $request;
        $this->lastResponse = $response;

        return $response;
    }

    /**
     * @return Request
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * @return Response
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate($method, $tokenOrLogin, $password = null)
    {
        if (GithubClient::AUTH_HTTP_TOKEN === $method) {
            $this->headers['Authorization'] = sprintf('token %s', $tokenOrLogin);
        }

        throw new \RuntimeException(sprintf('%s not yet implemented', $method));
    }
}
