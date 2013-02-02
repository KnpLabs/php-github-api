<?php

namespace Github\Api;

use Github\Client;

/**
 * Abstract class for Api classes
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
abstract class AbstractApi implements ApiInterface
{
    /**
     * The client
     *
     * @var Client
     */
    protected $client;

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
     * {@inheritDoc}
     */
    protected function get($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->executeRequest('GET', $path, $parameters, $requestHeaders);

        return $response->getContent();
    }

    /**
     * {@inheritDoc}
     */
    protected function post($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->executeRequest('POST', $path, $parameters, $requestHeaders);

        return $response->getContent();
    }

    /**
     * {@inheritDoc}
     */
    protected function patch($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->executeRequest('PATCH', $path, $parameters, $requestHeaders);

        return $response->getContent();
    }

    /**
     * {@inheritDoc}
     */
    protected function put($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->executeRequest('PUT', $path, $parameters, $requestHeaders);

        return $response->getContent();
    }

    /**
     * {@inheritDoc}
     */
    protected function delete($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->executeRequest('DELETE', $path, $parameters, $requestHeaders);

        return $response->getContent();
    }
}
