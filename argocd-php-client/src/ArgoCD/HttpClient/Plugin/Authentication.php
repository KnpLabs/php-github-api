<?php
namespace ArgoCD\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Psr\Http\Message\RequestInterface;
use ArgoCD\AuthMethod; // Assuming AuthMethod.php was created in the previous step

class Authentication implements Plugin
{
    private string $token;
    private string $authMethod;

    public function __construct(string $token, string $method = AuthMethod::BEARER_TOKEN)
    {
        $this->token = $token;
        $this->authMethod = $method;
    }

    public function handleRequest(\Psr\Http\Message\RequestInterface $request, callable $next, callable $first): \Http\Promise\Promise
    {
        if ($this->authMethod === AuthMethod::BEARER_TOKEN) {
            $request = $request->withHeader('Authorization', 'Bearer ' . $this->token);
        }
        // Potentially add other auth methods here if ArgoCD supports them

        return $next($request);
    }
}
