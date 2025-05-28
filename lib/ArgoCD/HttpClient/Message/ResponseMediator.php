<?php

namespace ArgoCD\HttpClient\Message;

use Psr\Http\Message\ResponseInterface;
// No specific ArgoCD exceptions are defined yet, so no ApiLimitExceedException equivalent for now.

final class ResponseMediator
{
    /**
     * @param ResponseInterface $response
     *
     * @return array|string
     */
    public static function getContent(ResponseInterface $response)
    {
        $body = $response->getBody()->__toString();
        // ArgoCD API primarily uses JSON.
        if (strpos($response->getHeaderLine('Content-Type'), 'application/json') === 0) {
            $content = json_decode($body, true);
            if (JSON_ERROR_NONE === json_last_error()) {
                return $content;
            }
        }

        return $body; // Return raw body if not JSON or if JSON decoding fails
    }

    /**
     * Get the value for a single header.
     * (Kept as it might be useful, though ArgoCD pagination is typically cursor-based or not via Link headers)
     *
     * @param ResponseInterface $response
     * @param string            $name
     *
     * @return string|null
     */
    public static function getHeader(ResponseInterface $response, string $name): ?string
    {
        $headers = $response->getHeader($name);

        return array_shift($headers);
    }

    // Removed getPagination() and getApiLimit() as they are GitHub specific.
    // ArgoCD error handling and rate limiting (if any) will be handled differently.
}
