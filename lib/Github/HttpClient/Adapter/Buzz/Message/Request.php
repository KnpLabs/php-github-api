<?php

namespace Github\HttpClient\Adapter\Buzz\Message;

use Buzz\Message\Request as BuzzRequest;
use Github\HttpClient\RequestInterface;

class Request implements RequestInterface
{
    private $request;

    public function __construct(BuzzRequest $request)
    {
        $this->request = $request;
    }

    public function getAdapterRequest()
    {
        return $this->request;
    }
}
