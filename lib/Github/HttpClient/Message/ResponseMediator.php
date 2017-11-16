<?php declare(strict_types=1);

namespace Github\HttpClient\Message;

use Github\Exception\ApiLimitExceedException;
use Psr\Http\Message\ResponseInterface;

class ResponseMediator
{
    /**
     *
     * @return array|string
     */
    public static function getContent(ResponseInterface $response)
    {
        $body = $response->getBody()->__toString();
        if (strpos($response->getHeaderLine('Content-Type'), 'application/json') === 0) {
            $content = json_decode($body, true);
            if (JSON_ERROR_NONE === json_last_error()) {
                return $content;
            }
        }

        return $body;
    }

    /**
     *
     * @return array|null
     */
    public static function getPagination(ResponseInterface $response)
    {
        if (!$response->hasHeader('Link')) {
            return null;
        }

        $header = self::getHeader($response, 'Link');
        $pagination = [];
        foreach (explode(',', $header) as $link) {
            preg_match('/<(.*)>; rel="(.*)"/i', trim($link, ','), $match);

            if (3 === count($match)) {
                $pagination[$match[2]] = $match[1];
            }
        }

        return $pagination;
    }

    /**
     *
     * @return null|string
     */
    public static function getApiLimit(ResponseInterface $response)
    {
        $remainingCalls = self::getHeader($response, 'X-RateLimit-Remaining');

        if (null !== $remainingCalls && 1 > $remainingCalls) {
            throw new ApiLimitExceedException($remainingCalls);
        }
        
        return $remainingCalls;
    }
    
    /**
     * Get the value for a single header
     * @param string $name
     *
     * @return string|null
     */
    public static function getHeader(ResponseInterface $response, string $name)
    {
        $headers = $response->getHeader($name);

        return array_shift($headers);
    }
}
