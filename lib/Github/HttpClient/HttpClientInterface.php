<?php

namespace Github\HttpClient;

use Github\Exception\InvalidArgumentException;

/**
 * Performs requests on GitHub API. API documentation should be self-explanatory.
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
interface HttpClientInterface
{
    /**
     * Send a GET request
     *
     * @param  string $path       Request path
     * @param  array  $parameters GET Parameters
     * @param  array  $headers    Reconfigure the request headers for this call only
     *
     * @return array              Data
     */
    public function get($path, array $parameters = array(), array $headers = array());

    /**
     * Send a POST request
     *
     * @param  string $path       Request path
     * @param  array  $parameters POST Parameters
     * @param  array  $headers    Reconfigure the request headers for this call only
     *
     * @return array              Data
     */
    public function post($path, array $parameters = array(), array $headers = array());

    /**
     * Send a PATCH request
     *
     * @param  string $path       Request path
     * @param  array  $parameters PATCH Parameters
     * @param  array  $headers    Reconfigure the request headers for this call only
     *
     * @return array              Data
     */
    public function patch($path, array $parameters = array(), array $headers = array());

    /**
     * Send a PUT request
     *
     * @param  string $path       Request path
     * @param  array  $parameters PUT Parameters
     * @param  array  $headers    Reconfigure the request headers for this call only
     *
     * @return array              Data
     */
    public function put($path, array $parameters = array(), array $headers = array());

    /**
     * Send a DELETE request
     *
     * @param  string $path       Request path
     * @param  array  $parameters DELETE Parameters
     * @param  array  $headers    Reconfigure the request headers for this call only
     *
     * @return array              Data
     */
    public function delete($path, array $parameters = array(), array $headers = array());

    /**
     * Send a request to the server, receive a response,
     * decode the response and returns an associative array
     *
     * @param  string $path       Request API path
     * @param  array  $parameters Parameters
     * @param  string $httpMethod HTTP method to use
     * @param  array  $headers    Request headers
     *
     * @return array              Data
     */
    public function request($path, array $parameters = array(), $httpMethod = 'GET', array $headers = array());

    /**
     * Change an option value.
     *
     * @param string $name   The option name
     * @param mixed  $value  The value
     *
     * @throws InvalidArgumentException
     */
    public function setOption($name, $value);

    /**
     * Set HTTP headers
     *
     * @param array $headers
     */
    public function setHeaders(array $headers);

    /**
     * Removes all headers previously set
     */
    public function clearHeaders();

    /**
     * Authenticate HttpClient requests with parameters
     *
     * @param string      $method
     * @param string      $tokenOrLogin
     * @param string|null $password
     */
    public function authenticate($method, $tokenOrLogin, $password = null);

    /**
     * Return the last request that has been executed
     *
     * @return RequestInterface
     */
    public function getLastRequest();

    /**
     * Return the last response that has been received
     *
     * @return ResponseInterface
     */
    public function getLastResponse();

    /**
     * Return the API Limit with the current authentication state
     *
     * @return Integer
     */
    public function getAPILimit();

    /**
     * Return the API remaining request quantity with the current authentication state
     *
     * @return Integer
     */
    public function getAPIRemaining();
}
