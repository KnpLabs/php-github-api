## Repo / Hooks API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

For extended info see the [Github documentation](https://docs.github.com/en/rest/reference/repos#webhooks)

### List repository webhooks

```php
$hooks = $client->api('repo')->hooks()->all('twbs', 'bootstrap');
```

### Get a repository webhook

```php
$hook = $client->api('repo')->hooks()->show('twbs', 'bootstrap', $hookId);
```

### Create a repository webhook

```php
$client->api('repo')->hooks()->create('twbs', 'bootstrap', $parameters);
```

### Update a repository webhook

```php
$client->api('repo')->hooks()->update('twbs', 'bootstrap', $hookId, $parameters);
```

### Delete a repository webhook

```php
$client->api('repo')->hooks()->remove('twbs', 'bootstrap', $hookId);
```

### Ping a repository webhook

```php
$client->api('repo')->hooks()->ping('twbs', 'bootstrap', $hookId);
```

### Test the push repository webhook

```php
$client->api('repo')->hooks()->test('twbs', 'bootstrap', $hookId);
```
