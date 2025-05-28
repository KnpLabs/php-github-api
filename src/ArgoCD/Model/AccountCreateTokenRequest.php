<?php
namespace ArgoCD\Model;

class AccountCreateTokenRequest
{
    private ?string $expiresIn = null; // Duration string e.g., "30d", "24h", or "0" for non-expiring
    private ?string $id = null;        // Desired token ID
    private ?string $name = null;      // Token's display name/description

    public function __construct(array $data = [])
    {
        $this->expiresIn = $data['expiresIn'] ?? null;
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
    }

    public function setExpiresIn(?string $expiresIn): self
    {
        $this->expiresIn = $expiresIn;
        return $this;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getExpiresIn(): ?string
    {
        return $this->expiresIn;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        $payload = [];
        // According to typical ArgoCD API usage for creating tokens,
        // 'name' in the path is the account name.
        // 'id' in the body is the token's identifier/name.
        // 'expiresIn' in the body is the token's expiration duration.
        // The 'name' field in the body for this request is often used as the token's description or friendly name.
        // The OpenAPI spec has 'name' in the body, which is slightly ambiguous.
        // Let's assume 'id' is the token's unique ID, and 'name' (body) is a display name.
        // If 'name' from the constructor is meant for the account, it shouldn't be in this payload.
        // The method signature for createToken in service will have $accountName for the path.
        
        if ($this->id !== null) {
            // This 'id' in the request body is often used as the token's name or identifier.
            // The API might also have a 'name' field for a description.
            // The OpenAPI spec is: properties: { expiresIn, id, name }
            // Let's assume 'id' is the desired token ID, and 'name' is its description.
            $payload['id'] = $this->id;
        }
        if ($this->name !== null) {
             // This 'name' field is for the token's display name/description.
            $payload['name'] = $this->name;
        }
        if ($this->expiresIn !== null) {
            $payload['expiresIn'] = $this->expiresIn;
        } else {
            // Default to non-expiring if not specified, or API might require it
            $payload['expiresIn'] = "0"; 
        }
        return $payload;
    }
}
