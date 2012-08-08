<?php

namespace Github\Api;

use Github\Client;

/**
 * Abstract class for Api classes
 *
 * @author Thibault Duplessis <thibault.duplessis at gmail dot com>
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

    /**
     * {@inheritDoc}
     */
    protected function get($path, array $parameters = array(), $requestOptions = array())
    {
        return $this->client->get($path, $parameters, $requestOptions);
    }

    /**
     * {@inheritDoc}
     */
    protected function post($path, array $parameters = array(), $requestOptions = array())
    {
        return $this->client->post($path, $parameters, $requestOptions);
    }

    /**
     * {@inheritDoc}
     */
    protected function patch($path, array $parameters = array(), $requestOptions = array())
    {
        return $this->client->patch($path, $parameters, $requestOptions);
    }

    /**
     * {@inheritDoc}
     */
    protected function put($path, array $parameters = array(), $requestOptions = array())
    {
        return $this->client->put($path, $parameters, $requestOptions);
    }

    /**
     * {@inheritDoc}
     */
    protected function delete($path, array $parameters = array(), $requestOptions = array())
    {
        return $this->client->delete($path, $parameters, $requestOptions);
    }

    /**
     * Translates array to object, for proper json data (forcing `[]` instead of `{}`)
     *
     * @param array $params
     *
     * @return object
     */
    protected function translateArrayToObject(array $params)
    {
        $object = new \stdClass();
        foreach ($params as $key => $param) {
            $object->$key = $param;
        }

        return $object;
    }
}
