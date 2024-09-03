# Copilot Usage API Documentation
[Back to the navigation](../README.md)

## Overview

The Copilot Usage API provides endpoints to retrieve usage summaries for organizations and enterprises.

**Note**: This endpoint is in beta and is subject to change.

## Endpoints

### Organization Usage Summary

Retrieve the usage summary for a specific organization.

**Method:** `GET`

**Endpoint:** `/orgs/{organization}/copilot/usage`

**Parameters:**
- `organization` (string): The name of the organization.
- `params` (array, optional): Additional query parameters.

**Example:**
```php
$usage = $client->api('copilotUsage')->orgUsageSummary('KnpLabs');
```

### Organization Team Usage Summary

Retrieve the usage summary for a specific team within an organization.

**Method:** `GET`

**Endpoint:** `/orgs/{organization}/team/{team}/copilot/usage`

**Parameters:**
- `organization` (string): The name of the organization.
- `team` (string): The name of the team.
- `params` (array, optional): Additional query parameters.

**Example:**
```php
$usage = $client->api('copilotUsage')->orgTeamUsageSummary('KnpLabs', 'developers');
```

### Enterprise Usage Summary

Retrieve the usage summary for a specific enterprise.

**Method:** `GET`

**Endpoint:** `/enterprises/{enterprise}/copilot/usage`

**Parameters:**
- `enterprise` (string): The name of the enterprise.
- `params` (array, optional): Additional query parameters.

**Example:**
```php
$usage = $client->api('copilotUsage')->enterpriseUsageSummary('KnpLabs');
```

### Enterprise Team Usage Summary

Retrieve the usage summary for a specific team within an enterprise.

**Method:** `GET`

**Endpoint:** `/enterprises/{enterprise}/team/{team}/copilot/usage`

**Parameters:**
- `enterprise` (string): The name of the enterprise.
- `team` (string): The name of the team.
- `params` (array, optional): Additional query parameters.

**Example:**
```php
$usage = $client->api('copilotUsage')->enterpriseTeamUsageSummary('KnpLabs', 'developers');
```
