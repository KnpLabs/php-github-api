<?php

namespace ArgoCD\Api;

use ArgoCD\Client;
use ArgoCD\HttpClient\Message\ResponseMediator;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractApi
{
    /**
     * The client instance.
     *
     * @var Client
     */
    protected $client; // Changed visibility to protected to allow access in child classes if needed

    /**
     * Create a new API instance.
     *
     * @param Client $client
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the client instance.
     *
     * @return Client
     */
    protected function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @return $this
     */
    public function configure()
    {
        // Kept as a no-op or simple method returning $this
        return $this;
    }

    /**
     * Send a GET request with query parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     GET parameters.
     * @param array  $requestHeaders Request Headers.
     *
     * @return array|string
     */
    protected function get(string $path, array $parameters = [], array $requestHeaders = [])
    {
        // Removed $perPage logic
        // Removed 'ref' parameter logic as it's GitHub specific

        if (count($parameters) > 0) {
            $path .= '?'.http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
        }

        $response = $this->client->getHttpClient()->get($path, $requestHeaders);

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a HEAD request with query parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     HEAD parameters.
     * @param array  $requestHeaders Request headers.
     *
     * @return ResponseInterface
     */
    protected function head(string $path, array $parameters = [], array $requestHeaders = []): ResponseInterface
    {
        // Removed 'ref' parameter logic
        $queryString = '';
        if (count($parameters) > 0) {
            $queryString = '?'.http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
        }
        return $this->client->getHttpClient()->head($path.$queryString, $requestHeaders);
    }

    /**
     * Send a POST request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return array|string
     */
    protected function post(string $path, array $parameters = [], array $requestHeaders = [])
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
     * @param string|null $body      Request body.
     * @param array  $requestHeaders Request headers.
     *
     * @return array|string
     */
    protected function postRaw(string $path, $body, array $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->post(
            $path,
            $requestHeaders,
            $body
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a PATCH request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return array|string
     */
    protected function patch(string $path, array $parameters = [], array $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->patch(
            $path,
            $requestHeaders,
            $this->createJsonBody($parameters)
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a PUT request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return array|string
     */
    protected function put(string $path, array $parameters = [], array $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->put(
            $path,
            $requestHeaders,
            $this->createJsonBody($parameters)
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a DELETE request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return array|string
     */
    protected function delete(string $path, array $parameters = [], array $requestHeaders = [])
    {
        // ArgoCD DELETE requests might not always have a body.
        // If parameters are provided, assume they are for the body.
        // If not, send null as the body.
        $body = null;
        if (count($parameters) > 0) {
            $body = $this->createJsonBody($parameters);
        }
        
        $response = $this->client->getHttpClient()->delete(
            $path,
            $requestHeaders,
            $body
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Create a JSON encoded version of an array of parameters.
     *
     * @param array $parameters Request parameters
     *
     * @return string|null
     */
    protected function createJsonBody(array $parameters): ?string
    {
        // Ensure empty array results in null, not "[]" for some ArgoCD endpoints if they expect no body.
        // However, for POST/PUT/PATCH, an empty JSON object "{}" might be valid.
        // The original behavior is to return null for empty arrays, which is generally fine.
        return (count($parameters) === 0) ? null : json_encode($parameters, empty($parameters) ? JSON_FORCE_OBJECT : 0);
    }
}
