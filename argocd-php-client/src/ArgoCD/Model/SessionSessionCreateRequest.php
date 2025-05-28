<?php
namespace ArgoCD\Model;

class SessionSessionCreateRequest
{
    private ?string $password = null;
    private ?string $token = null;
    private ?string $username = null;

    public function __construct(array $data = [])
    {
        $this->password = $data['password'] ?? null;
        $this->token = $data['token'] ?? null;
        $this->username = $data['username'] ?? null;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    // It might be useful to have setters for a request object
    // or a method to convert to array for the request body.
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }
    
    public function toArray(): array
    {
        $payload = [];
        if ($this->username !== null) {
            $payload['username'] = $this->username;
        }
        if ($this->password !== null) {
            $payload['password'] = $this->password;
        }
        if ($this->token !== null) {
            $payload['token'] = $this->token;
        }
        return $payload;
    }
}
