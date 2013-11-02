<?php

namespace Github\Tests\Mock;

use Guzzle\Http\Message\Response;

class TestResponse extends Response
{
    protected $loopCount;

    protected $content;

    public function __construct($loopCount, array $content = array())
    {
        $this->loopCount = $loopCount;
        $this->content   = $content;
    }

    /**
     * {@inheritDoc}
     */
    public function getBody($asString = false)
    {
        return json_encode($this->content);
    }

    public function getHeader($header = null)
    {
        if ($this->loopCount) {
            $header = sprintf('<https://api.github.com/%d>; rel="next"', $this->loopCount);
        } else {
            $header = '<https://api.github.com/prev>; rel="prev"';
        }

        $this->loopCount--;

        return $header;
    }
}
