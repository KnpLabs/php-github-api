<?php

namespace Github\HttpClient;

/**
 * Performs requests on GitHub API. API documentation should be self-explanatory.
 *
 * @author Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
interface HttpClientInterface
{
    /**
     * Send a GET request
     *
     * @param  string   $path       Request path
     * @param  array    $parameters GET Parameters
     * @param  array    $options    Reconfigure the request for this call only
     *
     * @return array                Data
     */
    public function get($path, array $parameters = array(), array $options = array());

    /**
     * Send a POST request
     *
     * @param  string   $path       Request path
     * @param  array    $parameters POST Parameters
     * @param  array    $options    Reconfigure the request for this call only
     *
     * @return array                Data
     */
    public function post($path, array $parameters = array(), array $options = array());

    /**
     * Send a PATCH request
     *
     * @param  string   $path       Request path
     * @param  array    $parameters PATCH Parameters
     * @param  array    $options    Reconfigure the request for this call only
     *
     * @return array                Data
     */
    public function patch($path, array $parameters = array(), array $options = array());

    /**
     * Send a PUT request
     *
     * @param  string   $path       Request path
     * @param  array    $options    Reconfigure the request for this call only
     *
     * @return array                Data
     */
    public function put($path, array $options = array());

    /**
     * Send a DELETE request
     *
     * @param  string   $path       Request path
     * @param  array    $parameters DELETE Parameters
     * @param  array    $options    Reconfigure the request for this call only
     *
     * @return array                Data
     */
    public function delete($path, array $parameters = array(), array $options = array());

    /**
     * Authenticate a user for all next requests
     */
    public function authenticate();

    /**
     * Change an option value.
     *
     * @param string $name   The option name
     * @param mixed  $value  The value
     *
     * @return HttpClientInterface The current object instance
     */
    public function setOption($name, $value);

    /**
     * Set HTTP headers
     *
     * @param array $headers
     * @return HttpClientInterface The current object instance
     */
    public function setHeaders(array $headers);
}
