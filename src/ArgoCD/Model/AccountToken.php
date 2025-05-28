<?php
namespace ArgoCD\Model;

class AccountToken
{
    private ?string $expiresAt = null; // String representation of int64 (timestamp)
    private ?string $id = null;
    private ?string $issuedAt = null;  // String representation of int64 (timestamp)

    public function __construct(array $data = [])
    {
        $this->expiresAt = $data['expiresAt'] ?? null;
        $this->id = $data['id'] ?? null;
        $this->issuedAt = $data['issuedAt'] ?? null;
    }

    public function getExpiresAt(): ?string
    {
        return $this->expiresAt;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getIssuedAt(): ?string
    {
        return $this->issuedAt;
    }

    // Optional: Convert expiresAt to DateTimeImmutable
    public function getExpiresAtDateTime(): ?\DateTimeImmutable
    {
        if ($this->expiresAt === null) {
            return null;
        }
        $dateTime = new \DateTimeImmutable();
        return $dateTime->setTimestamp((int)$this->expiresAt);
    }

    // Optional: Convert issuedAt to DateTimeImmutable
    public function getIssuedAtDateTime(): ?\DateTimeImmutable
    {
        if ($this->issuedAt === null) {
            return null;
        }
        $dateTime = new \DateTimeImmutable();
        return $dateTime->setTimestamp((int)$this->issuedAt);
    }
}
