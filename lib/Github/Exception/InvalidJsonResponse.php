<?php

namespace Github\Exception;

class InvalidJsonResponse extends RuntimeException
{
    private $body;
    
    public function __construct($body, $code = 0, $previous = null)
    {
        $this->body = $body;
        parent::__construct('Invalid Json Response', $code, $previous);
    }

    public function getBody()
    {
        return $this->body;
    }
}
