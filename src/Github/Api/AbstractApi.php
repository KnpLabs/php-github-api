<?php

namespace Github\Api;

use Github\Client;
use Github\HttpClient\Message\ResponseMediator;

/**
 * Abstract class for Api classes.
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
abstract class AbstractApi implements ApiInterface
{
    /**
     * The client.
     *
     * @var Client
     */
    protected $client;

    /**
     * Number of items per page (GitHub pagination).
     *
     * @var null|int
     */
    protected $perPage;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function configure()
    {
    }

    /**
     * @return null|int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @param null|int $perPage
     */
    public function setPerPage($perPage)
    {
        $this->perPage = (null === $perPage ? $perPage : (int) $perPage);

        return $this;
    }

    /**
     * Send a GET request with query parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     GET parameters.
     * @param array  $requestHeaders Request Headers.
     *
     * @return \Guzzle\Http\EntityBodyInterface|mixed|string
     */
    protected function get($path, array $parameters = array(), $requestHeaders = array())
    {
        if (null !== $this->perPage && !isset($parameters['per_page'])) {
            $parameters['per_page'] = $this->perPage;
        }
        if (array_key_exists('ref', $parameters) && is_null($parameters['ref'])) {
            unset($parameters['ref']);
        }
        $response = $this->client->getHttpClient()->get($path, $parameters, $requestHeaders);

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a HEAD request with query parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     HEAD parameters.
     * @param array  $requestHeaders Request headers.
     *
     * @return \Guzzle\Http\Message\Response
     */
    protected function head($path, array $parameters = array(), $requestHeaders = array())
    {
        if (array_key_exists('ref', $parameters) && is_null($parameters['ref'])) {
            unset($parameters['ref']);
        }

        $response = $this->client->getHttpClient()->request($path, null, 'HEAD', $requestHeaders, array(
            'query' => $parameters
        ));

        return $response;
    }

    /**
     * Send a POST request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     */
    protected function post($path, array $parameters = array(), $requestHeaders = array())
    {
        return $this->postRaw(
            $path,
            $this->createJsonBody($parameters),
            $requestHeaders
        );
    }

    /**
     * Send a POST request with raw data.
     *
     * @param string $path           Request path.
     * @param $body                     Request body.
     * @param array  $requestHeaders Request headers.
     *
     * @return \Guzzle\Http\EntityBodyInterface|mixed|string
     */
    protected function postRaw($path, $body, $requestHeaders = array())
    {
        $response = $this->client->getHttpClient()->post(
            $path,
            $body,
            $requestHeaders
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a PATCH request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     */
    protected function patch($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->getHttpClient()->patch(
            $path,
            $this->createJsonBody($parameters),
            $requestHeaders
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a PUT request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     */
    protected function put($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->getHttpClient()->put(
            $path,
            $this->createJsonBody($parameters),
            $requestHeaders
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a DELETE request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     */
    protected function delete($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->getHttpClient()->delete(
            $path,
            $this->createJsonBody($parameters),
            $requestHeaders
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Create a JSON encoded version of an array of parameters.
     *
     * @param array $parameters Request parameters
     *
     * @return null|string
     */
    protected function createJsonBody(array $parameters)
    {
        return (count($parameters) === 0) ? null : json_encode($parameters, empty($parameters) ? JSON_FORCE_OBJECT : 0);
    }
}
