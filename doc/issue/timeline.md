## Issues / Timeline API
[Back to the "Issues API"](../issues.md) | [Back to the navigation](../README.md)

Wraps [GitHub Issue Timeline API](https://docs.github.com/rest/issues/timeline).

This api is currently only available to developers in Early Access. To access the API during the Early Access period,
you must provide a custom media type in the Accept header.

```php
$client->api('ìssue')->timeline()->configure();
```

### List events for an issue

```php
$events = $client->api('issue')->timeline()->all('KnpLabs', 'php-github-api', 123);
```
