## Issues / Milestones API
[Back to the "Issues API"](../issues.md) | [Back to the navigation](../README.md)

Wraps [GitHub Issue Milestones API](http://developer.github.com/v3/issues/milestones/).

### List milestones for a repository

```php
$milestones = $client->api('issue')->milestones()->all('KnpLabs', 'php-github-api');
```

### Get information about milestone

```php
$milestone = $client->api('issue')->milestones()->show('KnpLabs', 'php-github-api', 123);
```

### Create a new milestone

```php
$milestone = $client->api('issue')->milestones()->create('KnpLabs', 'php-github-api', array('title' => '3.0'));
```

### Update a milestone

```php
$milestone = $client->api('issue')->milestones()->update('KnpLabs', 'php-github-api', 123, array('title' => '3.0'));
```

### Remove a milestone

```php
$client->api('issue')->milestones()->remove('KnpLabs', 'php-github-api', 123);
```

### List milestone labels

```php
$labels = $client->api('issue')->milestones()->labels('KnpLabs', 'php-github-api', 123);
```
