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
        $response = $this->client->getHttpClient()->get($path, $parameters, $requestHeaders);
        $responseContent = $response->getContent();
        $pagination = $response->getPagination();
        if (isset($pagination['next'])) {
            $nextPageResponse = $this->get(str_replace($this->client->getOption('base_url'), '', $pagination['next']), $parameters, $requestHeaders);
            foreach ($nextPageResponse as $item) {
                $responseContent[] = $item;
            }
        }

        return $responseContent;
    }

    /**
     * {@inheritDoc}
     */
    protected function post($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->getHttpClient()->post($path, $parameters, $requestHeaders);

        return $response->getContent();
    }

    /**
     * {@inheritDoc}
     */
    protected function patch($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->getHttpClient()->patch($path, $parameters, $requestHeaders);

        return $response->getContent();
    }

    /**
     * {@inheritDoc}
     */
    protected function put($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->getHttpClient()->put($path, $parameters, $requestHeaders);

        return $response->getContent();
    }

    /**
     * {@inheritDoc}
     */
    protected function delete($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->getHttpClient()->delete($path, $parameters, $requestHeaders);

        return $response->getContent();
    }
}
