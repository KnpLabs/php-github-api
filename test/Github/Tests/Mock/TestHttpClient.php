<?php

namespace Github\Tests\Mock;

use Github\HttpClient\HttpClientInterface;

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
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    public function get($path, array $parameters = array(), array $headers = array())
    {
        $this->requests['get'][] = $path;
    }

    public function post($path, array $parameters = array(), array $headers = array())
    {
        $this->requests['post'][] = $path;
    }

    public function patch($path, array $parameters = array(), array $headers = array())
    {
        $this->requests['patch'][] = $path;
    }

    public function put($path, array $options = array(), array $headers = array())
    {
        $this->requests['put'][] = $path;
    }

    public function delete($path, array $parameters = array(), array $headers = array())
    {
        $this->requests['delete'][] = $path;
    }

    public function request($path, array $parameters = array(), $httpMethod = 'GET', array $headers = array())
    {
        $this->requests[$httpMethod][] = $path;
    }
}
