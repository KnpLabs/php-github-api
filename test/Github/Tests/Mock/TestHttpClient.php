<?php

namespace Github\Tests\Mock;

use Github\HttpClient\HttpClientInterface;

/**
 * HTTPClient test implementation
 *
 * @author Leszek Prabucki <leszek.prabucki@gmail.com>
 */
class TestHttpClient implements HttpClientInterface
{
    public $authenticated = false;

    public $requests = array(
        'get' => array(),
        'post' => array(),
        'patch' => array(),
        'put' => array(),
        'delete' => array(),
    );
    public $options = array();
    public $headers = array();

    public function authenticate()
    {
        $this->authenticated = true;
    }

    public function setOption($key, $value)
    {
        $this->options[$key] = $value;

        return $this;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    public function get($path, array $parameters = array(), array $options = array())
    {
        $this->requests['get'][] = $path;
    }

    public function post($path, array $parameters = array(), array $options = array())
    {
        $this->requests['post'][] = $path;
    }

    public function patch($path, array $parameters = array(), array $options = array())
    {
        $this->requests['patch'][] = $path;
    }

    public function put($path, array $options = array())
    {
        $this->requests['put'][] = $path;
    }

    public function delete($path, array $parameters = array(), array $options = array())
    {
        $this->requests['delete'][] = $path;
    }
}
