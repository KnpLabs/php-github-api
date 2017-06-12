## Repo / Protection API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

The Protection API is currently available for developers to preview.
To access the API during the preview period, you must provide a custom media type in the Accept header:

```php
$client->api('repo')->protection()->configure();
```

### List all branch protection

> Requires [authentication](../security.md).

```php
$protection = $client->api('repo')->protection()->show('twbs', 'bootstrap', 'master');
```

### Update branch protection

> Requires [authentication](../security.md).

For the full list of parameters see https://developer.github.com/v3/repos/branches/#parameters-1

```php
$params = [
    'required_status_checks' => null,
    'required_pull_request_reviews' => [
        'include_admins' => true,
    ],
    'enforce_admins' => true,
    'restrictions' => null,
];
$protection = $client->api('repo')->protection()->show('twbs', 'bootstrap', 'master', $params);
```

### Remove branch protection

> Requires [authentication](../security.md).

```php
$protection = $client->api('repo')->protection()->remove('twbs', 'bootstrap', 'master');
```
