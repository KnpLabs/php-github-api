<?php

namespace Github\Factory;

use Zend\Diactoros\Request;

class RequestFactory
{
    public function createRequest($method, $uri, array $headers, $body = 'php://temp')
    {
        return new Request($uri, $method, $body, $headers);
    }
}
