<?php
namespace ArgoCD\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ArgoCD\Exception\RuntimeException;
use ArgoCD\Exception\ValidationFailedException; // Example
use ArgoCD\HttpClient\Message\ResponseMediator;

class ArgoCDExceptionThrower implements Plugin
{
    public function handleRequest(RequestInterface $request, callable $next, callable $first): \Http\Promise\Promise
    {
        return $next($request)->then(function (ResponseInterface $response) {
            if ($response->getStatusCode() < 400) {
                return $response;
            }

            $content = ResponseMediator::getContent($response);

            if (is_array($content) && isset($content['error'])) {
                $errorMessage = $content['message'] ?? ($content['error'] ?? $response->getReasonPhrase());
                $errorCode = $content['code'] ?? $response->getStatusCode();

                // Example: Check for a specific type of error if ArgoCD provides such details
                // For instance, if a 400 error with a specific 'error' field means validation failed
                if ($response->getStatusCode() == 400 && str_contains(strtolower($errorMessage), 'validation')) {
                     throw new ValidationFailedException('Validation Failed: ' . $errorMessage, $response->getStatusCode(), null, $content['details'] ?? []);
                }

                throw new RuntimeException(sprintf('Error %s: %s', $errorCode, $errorMessage), $response->getStatusCode());
            }

            throw new RuntimeException(sprintf('HTTP error %d: %s', $response->getStatusCode(), $response->getReasonPhrase()), $response->getStatusCode());
        });
    }
}
