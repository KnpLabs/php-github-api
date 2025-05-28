<?php
namespace ArgoCD\Model;

class AccountCreateTokenResponse
{
    private ?string $token = null;

    public function __construct(array $data = [])
    {
        $this->token = $data['token'] ?? null;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }
}
