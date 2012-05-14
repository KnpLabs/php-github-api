<?php

namespace Github\HttpClient;

/**
 * Performs requests on GitHub API. API documentation should be self-explanatory.
 *
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
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
     * @param array
     */
    function setHeaders($headers);
}
