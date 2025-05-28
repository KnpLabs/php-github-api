<?php
namespace ArgoCD\Model;

class RuntimeError
{
    private ?int $code = null;
    private ?string $error = null;
    private ?string $message = null;
    // ArgoCD error responses sometimes include a 'details' field,
    // which might be an array of objects or strings.
    // For now, we'll add it as a flexible array.
    private ?array $details = null;


    public function __construct(array $data = [])
    {
        $this->code = isset($data['code']) ? (int)$data['code'] : null;
        $this->error = $data['error'] ?? null;
        $this->message = $data['message'] ?? null;
        $this->details = $data['details'] ?? null;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }
    
    public function getDetails(): ?array
    {
        return $this->details;
    }
}
