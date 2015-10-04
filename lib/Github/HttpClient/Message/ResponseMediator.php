<?php

namespace Github\HttpClient\Message;

use Github\Exception\ApiLimitExceedException;
use GuzzleHttp\Message\ResponseInterface;

class ResponseMediator
{
    /**
     * @param \GuzzleHttp\Message\ResponseInterface|\Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     */
    public static function getContent(ResponseInterface $response)
    {
        // Guzzle < 6 BC
        if (!$response instanceof \GuzzleHttp\Message\ResponseInterface && !$response instanceof \Psr\Http\Message\ResponseInterface) {
            throw new \InvalidArgumentException('Argument 1 of '.__METHOD__.' must be on instance of \GuzzleHttp\Message\ResponseInterface or \Psr\Http\Message\ResponseInterface');
        }

        $body    = $response->getBody()->getContents();
        $content = json_decode($body, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return $body;
        }

        return $content;
    }

    /**
     * @param \GuzzleHttp\Message\ResponseInterface|\Psr\Http\Message\ResponseInterface $response $response
     *
     * @return array|null
     */
    public static function getPagination($response)
    {
        // Guzzle < 6 BC
        if (!$response instanceof \GuzzleHttp\Message\ResponseInterface && !$response instanceof \Psr\Http\Message\ResponseInterface) {
            throw new \InvalidArgumentException('Argument 1 of '.__METHOD__.' must be on instance of \GuzzleHttp\Message\ResponseInterface or \Psr\Http\Message\ResponseInterface');
        }

        $header = (string) $response->getHeader('Link');

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

    /**
     * @param \GuzzleHttp\Message\ResponseInterface|\Psr\Http\Message\ResponseInterface $response $response
     *
     * @return string
     */
    public static function getApiLimit($response)
    {
        // Guzzle < 6 BC
        if (!$response instanceof \GuzzleHttp\Message\ResponseInterface && !$response instanceof \Psr\Http\Message\ResponseInterface) {
            throw new \InvalidArgumentException('Argument 1 of '.__METHOD__.' must be on instance of \GuzzleHttp\Message\ResponseInterface or \Psr\Http\Message\ResponseInterface');
        }

        $remainingCalls = (string) $response->getHeader('X-RateLimit-Remaining');

        if (null !== $remainingCalls && 1 > $remainingCalls) {
            throw new ApiLimitExceedException($remainingCalls);
        }

        return $remainingCalls;
    }
}
