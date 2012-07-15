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
    function get($path, array $parameters = array(), array $options = array());

    /**
     * Send a POST request
     *
     * @param  string   $path       Request path
     * @param  array    $parameters POST Parameters
     * @param  array    $options    Reconfigure the request for this call only
     *
     * @return array                Data
     */
    function post($path, array $parameters = array(), array $options = array());

    /**
     * Send a PATCH request
     *
     * @param  string   $path       Request path
     * @param  array    $parameters PATCH Parameters
     * @param  array    $options    Reconfigure the request for this call only
     *
     * @return array                Data
     */
    function patch($path, array $parameters = array(), array $options = array());

    /**
     * Send a PUT request
     *
     * @param  string   $path       Request path
     * @param  array    $options    Reconfigure the request for this call only
     *
     * @return array                Data
     */
    function put($path, array $options = array());

    /**
     * Send a DELETE request
     *
     * @param  string   $path       Request path
     * @param  array    $parameters DELETE Parameters
     * @param  array    $options    Reconfigure the request for this call only
     *
     * @return array                Data
     */
    function delete($path, array $parameters = array(), array $options = array());

    /**
     * Change an option value.
     *
     * @param string $name   The option name
     * @param mixed  $value  The value
     *
     * @return HttpClientInterface The current object instance
     */
    function setOption($name, $value);

    /**
     * Set HTTP headers
     *
     * @param array $headers
     */
    function setHeaders(array $headers);
}
