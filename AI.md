# AI-Assisted Development Context: PHP ArgoCD API Client

This document provides context on the development process of this PHP client for the ArgoCD API, which was significantly assisted by an AI agent named Jules.

## Project Goal

The primary goal of this project was to refactor an existing PHP client library (originally forked from a GitHub API client) and adapt it to become a fully functional client for the ArgoCD REST API. A key aspect of the refactoring was to move away from a model-based approach for requests and responses to a more direct, array-based interaction style, similar to the KnpLabs/php-github-api library.

## Development Process

The development process involved a collaborative effort between a human developer and the AI agent, Jules. Key aspects of this process include:

*   **Initial Request:** The human developer provided an issue statement outlining the need to fork the GitHub library, study its structure, and then refactor it to implement ArgoCD's OpenAPI specification (`reference/argocd_swagger.json`).
*   **Codebase Analysis:** Jules explored the existing GitHub client's codebase using tools to list files and read their content to understand its architecture and patterns.
*   **OpenAPI Analysis:** Jules fetched and analyzed the ArgoCD OpenAPI specification to understand its endpoints, data structures, and service organization.
*   **Planning & Refactoring Strategy:** Based on the analysis, Jules created a detailed, multi-step plan. A significant decision during this phase was to refactor the library to **remove dedicated Model classes** for API requests and responses.
    *   API methods now accept direct parameters (strings, arrays, booleans, etc.).
    *   Request bodies are constructed internally as associative arrays.
    *   API methods return associative arrays directly, representing the decoded JSON responses from the ArgoCD API.
    *   This array-based approach for request/response handling aligns more closely with the interaction style of the KnpLabs/php-github-api library.
*   **Iterative Implementation:** Jules executed the plan step-by-step by delegating specific, actionable tasks to a "Worker" agent. These tasks included:
    *   Creating new directory structures and removing old Model directories (e.g., `lib/ArgoCD/Model/`).
    *   Adapting core classes derived from the fork to work with the constraints of ArgoCD and the new array-based data handling.
    *   Implementing exception handling.
    *   Implementing API service classes (e.g., `SessionService.php`, `AccountService.php`, `ApplicationService.php`) with methods corresponding to ArgoCD API operations. These methods were designed to accept direct parameters and return associative arrays.
    *   Generating unit tests for the service classes, ensuring they correctly handle array-based inputs and outputs.
*   **Feedback Incorporation:** The human developer provided feedback at various stages (e.g., on directory structure, PHP version constraints, refactoring strategy), and Jules updated the plan and execution accordingly.

## Library Usage Examples

### Authentication

To use the client, first instantiate it and then authenticate.

**Username/Password Authentication:**
```php
<?php
require_once __DIR__ . '/vendor/autoload.php'; // Adjust path as needed

$client = new \ArgoCD\Client('https://your-argocd-server.com');

try {
    $client->authenticate('your-username', 'your-password');
    // Authentication successful, client is now configured with a token.
    echo "Authentication successful!\n";
} catch (\ArgoCD\Exception\InvalidArgumentException $e) {
    // Handle authentication failure (e.g., invalid credentials)
    echo "Authentication failed: " . $e->getMessage() . "\n";
} catch (\ArgoCD\Exception\RuntimeException $e) {
    // Handle API communication errors
    echo "API Error: " . $e->getMessage() . "\n";
}
```

**Token Authentication:**
```php
<?php
require_once __DIR__ . '/vendor/autoload.php'; // Adjust path as needed

$client = new \ArgoCD\Client('https://your-argocd-server.com');
$authToken = 'your-pre-existing-auth-token';

try {
    $client->authenticate($authToken);
    // Authentication successful, client is now configured with the provided token.
    echo "Authentication successful!\n";
} catch (\ArgoCD\Exception\InvalidArgumentException $e) {
    // Handle token validation issues (though less common for direct token auth)
    echo "Authentication failed: " . $e->getMessage() . "\n";
}
```
Successful authentication configures the client internally with the necessary token for subsequent API calls.

### Fetching Application Details

Once authenticated, you can interact with the API services. For example, to fetch application details:

```php
<?php
// Assuming $client is an authenticated ArgoCD\Client instance

try {
    /** @var \ArgoCD\Api\ApplicationService $applicationApi */
    $applicationApi = $client->api('application'); // or $client->applicationService()

    // List applications, e.g., filtered by project
    $appsList = $applicationApi->list(['projects' => ['default']]);
    echo "Applications in 'default' project:\n";
    print_r($appsList); // $appsList is an associative array

    // Get details for a specific application
    $appName = 'my-sample-app';
    $appDetails = $applicationApi->get($appName);
    echo "\nDetails for application '$appName':\n";
    print_r($appDetails); // $appDetails is an associative array

} catch (\ArgoCD\Exception\RuntimeException $e) {
    echo "API Error: " . $e->getMessage() . "\n";
}
```
Methods like `list()` and `get()` return associative arrays containing the application data directly decoded from the API's JSON response.

## Library Status

The refactoring to an array-based interaction style for the `AccountService`, `SessionService`, and `ApplicationService` is complete. These services now accept direct parameters for requests and return associative arrays for responses, simplifying their usage.

## Acknowledgements

*   The initial structure and patterns were derived from the excellent [KnpLabs/php-github-api](https://github.com/KnpLabs/php-github-api) library. The refactoring aimed to bring the request/response handling closer to this style.
*   The target API is [ArgoCD](https://argo-cd.readthedocs.io/en/stable/), and its OpenAPI specification (available in `reference/argocd_swagger.json` in this repository) was used as the blueprint for API implementation.
