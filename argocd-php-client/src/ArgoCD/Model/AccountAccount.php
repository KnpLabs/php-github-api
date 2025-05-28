<?php
namespace ArgoCD\Model;

class AccountAccount
{
    /** @var string[]|null */
    private ?array $capabilities = null;
    private ?bool $enabled = null;
    private ?string $name = null;
    /** @var AccountToken[] */
    private array $tokens = [];

    public function __construct(array $data = [])
    {
        if (isset($data['capabilities']) && is_array($data['capabilities'])) {
            $this->capabilities = $data['capabilities'];
        }
        $this->enabled = isset($data['enabled']) ? (bool)$data['enabled'] : null;
        $this->name = $data['name'] ?? null;

        if (isset($data['tokens']) && is_array($data['tokens'])) {
            foreach ($data['tokens'] as $tokenData) {
                if (is_array($tokenData)) {
                    $this->tokens[] = new AccountToken($tokenData);
                }
            }
        }
    }

    /**
     * @return string[]|null
     */
    public function getCapabilities(): ?array
    {
        return $this->capabilities;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return AccountToken[]
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }
}
