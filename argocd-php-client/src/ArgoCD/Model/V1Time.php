<?php
namespace ArgoCD\Model;

class V1Time
{
    private ?string $seconds = null; // Based on typical ArgoCD v1.Time, it's a string representing int64
    private ?int $nanos = null;

    public function __construct(array $data = [])
    {
        $this->seconds = $data['seconds'] ?? null;
        $this->nanos = isset($data['nanos']) ? (int)$data['nanos'] : null;
    }

    public function getSeconds(): ?string
    {
        return $this->seconds;
    }

    public function getNanos(): ?int
    {
        return $this->nanos;
    }

    public function toDateTime(): ?\DateTimeImmutable
    {
        if ($this->seconds === null) {
            return null;
        }
        // Assuming seconds is a string that can be cast to int for setTimestamp
        $dateTime = new \DateTimeImmutable();
        return $dateTime->setTimestamp((int)$this->seconds);
        // Note: Nanos are not easily representable in standard DateTime
    }
}
