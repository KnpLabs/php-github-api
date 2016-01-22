<?php

namespace Github\HttpClient\Message;

use Github\Exception\ApiLimitExceedException;
use Psr\Http\Message\ResponseInterface;

class ResponseMediator
{
    public static function getContent(ResponseInterface $response)
    {
        $body    = $response->getBody();
        $content = json_decode($body, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return $body;
        }

        return $content;
    }

    public static function getPagination(ResponseInterface $response)
    {
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

    public static function getApiLimit(ResponseInterface $response)
    {
        $remainingCalls = (string) $response->getHeader('X-RateLimit-Remaining');

        if (null !== $remainingCalls && 1 > $remainingCalls) {
            throw new ApiLimitExceedException($remainingCalls);
        }

        return $remainingCalls;
    }
}
