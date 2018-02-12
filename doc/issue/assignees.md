## Issues / Assignees API
[Back to the "Issues API"](../issues.md) | [Back to the navigation](../README.md)

Wraps [GitHub Issue Assignees API](https://developer.github.com/v3/issues/assignees/).

### List all available assignees

```php
$assignees = $client->api('issue')->assignees()->listAvailable('KnpLabs', 'php-github-api');
```

### Check if a user is an available assignee

```php
$info = $client->api('issue')->assignees()->check('KnpLabs', 'php-github-api', 'test-user');
```

### Add assignee

```php
$client->api('issue')->assignees()->add('KnpLabs', 'php-github-api', 4, ['assignees' => 'test-user']);
```

### Remove assignee

```php
$client->api('issue')->assignees()->remove('KnpLabs', 'php-github-api', 4, ['assignees' => 'test-user']);
```
