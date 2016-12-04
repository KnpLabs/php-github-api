## Repo / Columns API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

This api is currently only available to developers in Early Access. To access the API during the Early Access period, 
you must provide a custom media type in the Accept header.

Both repositories and organisations have projects. The api is only different for getting all project or retrieving a single project.
All the example use the repository projects column api but this also works form the organization api (`$client->api('org_projects')->columns()`)


```php
$client->api('repo')->projects()->columns()->configure();
```

### List all columns of a project

```php
$columns = $client->api('repo')->projects()->columns()->all($projectId);
```

### List one column

```php
$column = $client->api('repo')->projects()->columns()->show($columnId);
```

### Create a column

> Requires [authentication](../security.md).

```php
$column = $client->api('repo')->projects()->columns()->create($projectId, array('name' => 'Column name'));
```

### Edit a column

> Requires [authentication](../security.md).

```php
$column = $client->api('repo')->project()->columns()->update($columnId, array('name' => 'New name'));
```

### Remove a column

> Requires [authentication](../security.md).

```php
$column = $client->api('repo')->projects()->columns()->deleteColumn($columnId);
```

### Move a column

> Requires [authentication](../security.md).

```php
$column = $client->api('repo')->projects()->columns()->move($columnId, array('position' => 'first));
```
