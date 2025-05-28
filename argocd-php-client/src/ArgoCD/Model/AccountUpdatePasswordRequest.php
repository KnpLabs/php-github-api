<?php
namespace ArgoCD\Model;

class AccountUpdatePasswordRequest
{
    private ?string $currentPassword = null;
    private ?string $name = null;
    private ?string $newPassword = null;

    public function __construct(array $data = [])
    {
        $this->currentPassword = $data['currentPassword'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->newPassword = $data['newPassword'] ?? null;
    }

    public function setCurrentPassword(string $currentPassword): self
    {
        $this->currentPassword = $currentPassword;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;
        return $this;
    }

    public function getCurrentPassword(): ?string
    {
        return $this->currentPassword;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function toArray(): array
    {
        $payload = [];
        if ($this->currentPassword !== null) {
            $payload['currentPassword'] = $this->currentPassword;
        }
        if ($this->name !== null) {
            $payload['name'] = $this->name;
        }
        if ($this->newPassword !== null) {
            $payload['newPassword'] = $this->newPassword;
        }
        return $payload;
    }
}
