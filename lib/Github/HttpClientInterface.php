<?php

/**
 * Performs requests on GitHub API. API documentation should be self-explanatory.
 *
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
interface Github_HttpClientInterface
{
    /**
     * Send a GET request
     *
     * @param  string   $url            Request URL
     * @param  array    $parameters     GET Parameters
     * @param  string   $httpMethod     HTTP method to use
     * @param  array    $options        reconfigure the request for this call only
     *
     * @return array                    Data
     */
    public function get($url, array $parameters = array(), array $options = array());

    /**
     * Send a POST request
     *
     * @param  string   $url            Request URL
     * @param  array    $parameters     POST Parameters
     * @param  string   $httpMethod     HTTP method to use
     * @param  array    $options        reconfigure the request for this call only
     *
     * @return array                    Data
     */
    public function post($url, array $parameters = array(), array $options = array());

    /**
     * Configure the request
     *
     * @param   array               $options  Request options
     * @return  Github_HttpClientInterface $this     Fluent interface
     */
    public function configure(array $options);

    /**
     * Change an option value.
     *
     * @param string $name   The option name
     * @param mixed  $value  The value
     *
     * @return Github_HttpClientInterface The current object instance
     */
    public function setOption($name, $value);

    /**
     * Get an option value.
     *
     * @param  string $name The option name
     *
     * @return mixed  The option value
     */
    public function getOption($name, $default = null);
}
