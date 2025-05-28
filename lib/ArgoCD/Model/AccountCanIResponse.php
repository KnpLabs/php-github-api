<?php
namespace ArgoCD\Model;

class AccountCanIResponse
{
    private ?string $value = null;

    public function __construct(array $data = [])
    {
        // The response for can-i is typically just a string, not a JSON object.
        // However, AbstractApi::get usually expects a JSON response.
        // This needs to be handled either in AbstractApi or by how this model is populated.
        // For now, assuming $data might be ['value' => 'the_string_response'] or the direct string.
        if (isset($data['value'])) {
            $this->value = (string)$data['value'];
        } elseif (is_string($data)) { // Handle direct string response
             $this->value = $data;
        } else if (count($data) === 1 && is_string(current($data))) { // Handle if wrapped in an array with one string value
            $this->value = current($data);
        }

    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
