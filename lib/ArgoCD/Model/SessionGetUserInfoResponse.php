<?php
namespace ArgoCD\Model;

class SessionGetUserInfoResponse
{
    /** @var string[]|null */
    private ?array $groups = null;
    private ?string $iss = null;
    private ?bool $loggedIn = null;
    private ?string $username = null;

    public function __construct(array $data = [])
    {
        if (isset($data['groups']) && is_array($data['groups'])) {
            $this->groups = $data['groups'];
        }
        $this->iss = $data['iss'] ?? null;
        $this->loggedIn = isset($data['loggedIn']) ? (bool)$data['loggedIn'] : null;
        $this->username = $data['username'] ?? null;
    }

    /**
     * @return string[]|null
     */
    public function getGroups(): ?array
    {
        return $this->groups;
    }

    public function getIss(): ?string
    {
        return $this->iss;
    }

    public function isLoggedIn(): ?bool
    {
        return $this->loggedIn;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }
}
