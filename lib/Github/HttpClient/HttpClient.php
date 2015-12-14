<?php

namespace Github\HttpClient;

use Github\Exception\TwoFactorAuthenticationRequiredException;
use Github\Exception\ErrorException;
use Github\Exception\RuntimeException;
use Github\HttpClient\Listener\AuthListener;
use Github\HttpClient\Listener\ErrorListener;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Event\SubscriberInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Performs requests on GitHub API. API documentation should be self-explanatory.
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class HttpClient implements HttpClientInterface
{
    protected $options = array(
        'base_url'    => 'https://api.github.com/',

        'user_agent'  => 'php-github-api (http://github.com/KnpLabs/php-github-api)',
        'timeout'     => 10,

        'api_limit'   => 5000,
        'api_version' => 'v3',

        'cache_dir'   => null
    );

    protected $headers = array();

    /**
     * @var \GuzzleHttp\Message\Response|\GuzzleHttp\Psr7\Response
     */
    private $lastResponse;

    /**
     * @var \GuzzleHttp\Message\Request|\GuzzleHttp\Psr7\Request
     */
    private $lastRequest;

    /**
     * @param array           $options
     * @param ClientInterface $client
     */
    public function __construct(array $options = array(), ClientInterface $client = null)
    {
        $this->options = array_merge($this->options, $options);

        if (null === $client) {
            $client = new Client($this->options);
        }
        $this->client = $client;

        $this->addListener('request.error', array(new ErrorListener($this->options), 'onRequestError'));
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
     * Clears used headers.
     */
    public function clearHeaders()
    {
        $this->headers = array(
            'Accept' => sprintf('application/vnd.github.%s+json', $this->options['api_version']),
            'User-Agent' => sprintf('%s', $this->options['user_agent']),
        );
    }

    public function addListener($eventName, $listener)
    {
        $this->client->getEmitter()->on($eventName, $listener);
    }

    /**
     * @param SubscriberInterface $subscriber
     *
     * @deprecated since version 1.6, will be removed in 2.0
     */
    public function addSubscriber(SubscriberInterface $subscriber)
    {
        @trigger_error(__METHOD__.' method is deprecated since version 1.6 and will be dropped in 2.0');
        $this->client->getEmitter()->attach($subscriber);
    }

    /**
     * {@inheritDoc}
     */
    public function get($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, null, 'GET', $headers, array('query' => $parameters));
    }

    /**
     * {@inheritDoc}
     */
    public function post($path, $body = null, array $headers = array())
    {
        return $this->request($path, $body, 'POST', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function patch($path, $body = null, array $headers = array())
    {
        return $this->request($path, $body, 'PATCH', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($path, $body = null, array $headers = array())
    {
        return $this->request($path, $body, 'DELETE', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function put($path, $body, array $headers = array())
    {
        return $this->request($path, $body, 'PUT', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function request($path, $body = null, $httpMethod = 'GET', array $headers = array(), array $options = array())
    {
        $request = $this->createRequest($httpMethod, $path, $body, $headers, $options);

        try {
            $response = $this->client->send($request);
        } catch (\LogicException $e) {
            throw new ErrorException($e->getMessage(), $e->getCode(), $e);
        } catch (TwoFactorAuthenticationRequiredException $e) {
            throw $e;
        } catch (\RuntimeException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }

        $this->lastRequest  = $request;
        $this->lastResponse = $response;

        return $response;
    }

    /**
     * {@inheritDoc}
     */
    public function authenticate($tokenOrLogin, $password = null, $method)
    {
        $this->addListener('request.before_send', array(
            new AuthListener($tokenOrLogin, $password, $method), 'onRequestBeforeSend'
        ));
    }

    /**
     * @return \GuzzleHttp\Message\Request|\Guzzle\Http\Message\Request
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * @return \GuzzleHttp\Message\Response|\Guzzle\Http\Message\Response
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    protected function createRequest($httpMethod, $path, $body = null, array $headers = array(), array $options = array())
    {
        return $this->client->createRequest(
            $httpMethod,
            $path,
            array_merge($this->headers, $headers),
            $body,
            $options
        );
    }
}
