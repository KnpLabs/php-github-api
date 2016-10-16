## Repo / Columns API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

This api is currently only available to developers in Early Access. To access the API during the Early Access period, 
you must provide a custom media type in the Accept header.

```php
$client->api('repo')->projects()->columns()->configure();
```

### List all columns of a project

```php
$columns = $client->api('repo')->projects()->columns()->all('twbs', 'bootstrap', $projectId);
```

### List one column

```php
$column = $client->api('repo')->projects()->columns()->show('twbs', 'bootstrap', $columnId);
```

### Create a column

> Requires [authentication](../security.md).

```php
$column = $client->api('repo')->projects()->columns()->create('twbs', 'bootstrap', $projectId, array('name' => 'Column name'));
```

### Edit a column

> Requires [authentication](../security.md).

```php
$column = $client->api('repo')->project()->columns()->update('twbs', 'bootstrap', $columnId, array('name' => 'New name'));
```

### Remove a column

> Requires [authentication](../security.md).

```php
$column = $client->api('repo')->projects()->columns()->deleteColumn('twbs', 'bootstrap', $columnId);
```

### Move a column

> Requires [authentication](../security.md).

```php
$column = $client->api('repo')->projects()->columns()->move('twbs', 'bootstrap', $columnId, array('position' => 'first));
```
