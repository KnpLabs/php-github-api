## Repository / Secret Scanning API
[Back to the "Repos API"](../../repos.md) | [Back to the navigation](../../README.md)

# List secret-scanning alerts for a repository

https://docs.github.com/en/enterprise-server@3.5/rest/secret-scanning#list-secret-scanning-alerts-for-a-repository

```php
$alerts = $client->api('repos')->secretScanning()->alerts('KnpLabs', 'php-github-api');
```

# Get a secret-scanning alert

https://docs.github.com/en/enterprise-server@3.5/rest/secret-scanning#get-a-secret-scanning-alert

```php
$alert = $client->api('repos')->secretScanning()->getAlert('KnpLabs', 'php-github-api', $alertNumber);
```

# Update a secret-scanning alert

https://docs.github.com/en/enterprise-server@3.5/rest/secret-scanning#update-a-secret-scanning-alert

```php
$client->api('repos')->secretScanning()->updateAlert('KnpLabs', 'php-github-api', $alertNumber, [
    'state' => 'resolved',
    'resolution' => 'wont-fix'
]);
```

# List Locations for a secret-scanning alert

https://docs.github.com/en/enterprise-server@3.5/rest/secret-scanning#list-locations-for-a-secret-scanning-alert

```php
$locations = $client->api('repos')->secretScanning()->locations('KnpLabs', 'php-github-api', $alertNumber);
```
