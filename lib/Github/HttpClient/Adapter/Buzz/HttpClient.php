<?php

namespace Github\HttpClient\Adapter\Buzz;

use Buzz\Client\Curl;
use Buzz\Client\ClientInterface;
use Buzz\Listener\ListenerInterface;
use Buzz\Message\Request as BuzzRequest;
use Buzz\Message\Response as BuzzResponse;
use Github\Exception\ErrorException;
use Github\Exception\RuntimeException;
use Github\HttpClient\AbstractAdapter;
use Github\HttpClient\Adapter\Buzz\Listener\AuthListener;
use Github\HttpClient\Adapter\Buzz\Listener\ErrorListener;
use Github\HttpClient\Adapter\Buzz\Message\Request;
use Github\HttpClient\Adapter\Buzz\Message\Response;

/**
 * Performs requests on GitHub API. API documentation should be self-explanatory.
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class HttpClient extends AbstractAdapter
{
    /**
     * @var array
     */
    protected $options = array(
        'base_url'    => 'https://api.github.com/',

        'user_agent'  => 'php-github-api (http://github.com/KnpLabs/php-github-api)',
        'timeout'     => 10,
        'api_version' => 'beta',

        'cache_dir'   => null
    );
    /**
     * @var array
     */
    protected $listeners = array();

    /**
     * @param array           $options
     * @param ClientInterface $client
     */
    public function __construct(array $options = array(), ClientInterface $client = null)
    {
        $client = $client ?: new Curl();
        $client->setTimeout($this->options['timeout']);
        $client->setVerifyPeer(false);

        $this->options = array_merge($this->options, $options);
        $this->client  = $client;

        $this->addListener(new ErrorListener());

        $this->clearHeaders();
    }

    /**
     * @param ListenerInterface $listener
     */
    public function addListener(ListenerInterface $listener)
    {
        $this->listeners[get_class($listener)] = $listener;
    }

    /**
     * Returns listeners
     *
     * @return array
     */
    public function getListeners()
    {
        return $this->listeners;
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
        $path = trim($this->options['base_url'].$path, '/');

        var_dump($httpMethod, $path);
        $request = $this->createRequest($httpMethod, $path);
        $request->addHeaders($headers);
        $request->setContent(json_encode($parameters));

        $hasListeners = 0 < count($this->listeners);
        if ($hasListeners) {
            foreach ($this->listeners as $listener) {
                $listener->preSend($request);
            }
        }

        $response = $this->createResponse();

        try {
            $this->client->send($request, $response);
        } catch (\LogicException $e) {
            throw new ErrorException($e->getMessage());
        } catch (\RuntimeException $e) {
            throw new RuntimeException($e->getMessage());
        }

        if ($hasListeners) {
            foreach ($this->listeners as $listener) {
                $listener->postSend($request, $response);
            }
        }

        $this->lastRequest  = new Request($request);
        $this->lastResponse = new Response($response);

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate($method, $tokenOrLogin, $password = null)
    {
        $this->addListener(
            new AuthListener(
                $method,
                array(
                    'tokenOrLogin' => $tokenOrLogin,
                    'password'     => $password
                )
            )
        );;
    }

    /**
     * @param string $httpMethod
     * @param string $url
     *
     * @return Request
     */
    private function createRequest($httpMethod, $url)
    {
        $request = new BuzzRequest($httpMethod);
        $request->setHeaders($this->headers);
        $request->fromUrl($url);

        return $request;
    }

    /**
     * @return Response
     */
    private function createResponse()
    {
        return new BuzzResponse();
    }
}
