## Repo / Labels API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

### List all labels for this repository

```php
$labels = $client->api('repo')->labels()->all('twbs', 'bootstrap');
```

### Get a single label

```php
$label = $client->api('repo')->labels()->show('twbs', 'bootstrap', 'feature');
```

### Create a label

> Requires [authentication](../security.md).

```php
$params = [
  'name' => 'bug',
  'color' => 'f29513',
  'description' => 'Something isn\'t working',
];
$label = $client->api('repo')->labels()->create('twbs', 'bootstrap', $params);
```

### Update a label

> Requires [authentication](../security.md).

```php
$params = [
  'new_name' => 'bug :bug:',
  'color' => 'b01f26',
  'description' => 'Small bug fix required',
];
$label = $client->api('repo')->labels()->update('twbs', 'bootstrap', 'bug', $params);
```

### Delete a label

> Requires [authentication](../security.md).

```php
$label = $client->api('repo')->labels()->remove('twbs', 'bootstrap', 'bug');
```
