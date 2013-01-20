<?php

namespace Github\HttpClient\Adapter\Guzzle\Message;

use Guzzle\Http\Message\Response as GuzzleResponse;
use Github\HttpClient\ResponseInterface;

class Response implements ResponseInterface
{
    /** @var GuzzleResponse */
    private $response;
    private $remainingCalls;
    // fix this
    private $options = array();

    public function __construct(GuzzleResponse $response)
    {
        $this->response = $response;
    }


    public function getContent()
    {
        $content  = json_decode($this->response->getBody(true), true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return $this->response;
        }

        return $content;
    }

    /**
     * @return array|null
     */
    public function getPagination()
    {
        $header = $this->response->getHeader('Link', true);
        if (empty($header)) {
            return null;
        }

        $pagination = array();
        foreach (explode(',', $header) as $link) {
            preg_match('/<(.*)>; rel="(.*)"/i', trim($link, ','), $match);

            if (3 === count($match)) {
                $pagination[$match[2]] = $match[1];
            }
        }

        return $pagination;
    }

    public function getApiLimit()
    {
        $header = $this->response->getHeader('X-RateLimit-Remaining', true);
        if (!empty($header)) {
            $this->remainingCalls = $header;
        }

        if (null !== $this->remainingCalls && 1 > $this->remainingCalls) {
            throw new ApiLimitExceedException($this->options['api_limit']);
        }
    }

    public function isNotModified()
    {
        return 304 === $this->response->getStatusCode();
    }
}
