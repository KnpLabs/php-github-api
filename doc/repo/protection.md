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

```php
$protection = $client->api('repo')->protection()->show('twbs', 'bootstrap', 'master', $params);
```
