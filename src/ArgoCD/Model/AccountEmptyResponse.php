<?php
namespace ArgoCD\Model;

class AccountEmptyResponse
{
    // This class is intentionally empty as it represents an empty response body,
    // for example, from a successful DELETE operation that returns HTTP 204 No Content
    // or HTTP 200 OK with no body.

    public function __construct(array $data = [])
    {
        // No properties to initialize.
        // The constructor is kept for consistency.
    }
}
