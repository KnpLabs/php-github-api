<?php

namespace Github\Tests\Mock;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class PaginatedResponse extends Response
{
    protected $loopCount;

    protected $content;

    public function __construct($loopCount, array $content = [])
    {
        $this->loopCount = $loopCount;
        $this->content = $content;

        parent::__construct(200, ['Content-Type' => 'application/json'], Utils::streamFor(json_encode($content)));
    }

    public function getHeader($header): array
    {
        if ($header === 'Link') {
            if ($this->loopCount > 1) {
                $header = [sprintf('<https://api.github.com/%d>; rel="next"', $this->loopCount)];
            } else {
                $header = ['<https://api.github.com/prev>; rel="prev"'];
            }

            $this->loopCount--;

            return $header;
        }

        return parent::getHeader($header);
    }

    public function hasHeader($header): bool
    {
        if ($header === 'Link') {
            return true;
        }

        return parent::hasHeader($header);
    }
}
