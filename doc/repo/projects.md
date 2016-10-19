## Repo / Projects API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

This api is currently only available to developers in Early Access. To access the API during the Early Access period, 
you must provide a custom media type in the Accept header.

```php
$client->api('repo')->projects()->configure();
```

### List all projects

```php
$projects = $client->api('repo')->projects()->all('twbs', 'bootstrap');
```

### List one project

```php
$project = $client->api('repo')->projects()->show('twbs', 'bootstrap', $projectId);
```

### Create a project

> Requires [authentication](../security.md).

```php
$project = $client->api('repo')->projects()->create('twbs', 'bootstrap', array('name' => 'Project name'));
```

### Edit a project

> Requires [authentication](../security.md).

```php
$project = $client->api('repo')->project()->update('twbs', 'bootstrap', $projectId, array('name' => 'New name'));
```

### Remove a project

> Requires [authentication](../security.md).

```php
$project = $client->api('repo')->projects()->deleteProject('twbs', 'bootstrap', $projectId);
```
