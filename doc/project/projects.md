## Repo / Projects API
[Back to the "Repos API"](../) | [Back to the navigation](../README.md)

This api is currently only available to developers in Early Access. To access the API during the Early Access period, 
you must provide a custom media type in the Accept header.

Both repositories and organisations have projects. The api is only different for gettings all or a single project.
All the example use the repository projects api but this also works form the organization api (`$client->api('org_projects')`)

```php
$client->api('repo')->projects()->configure();
```

### List all projects

```php
$projects = $client->api('repo')->projects()->all('twbs', 'bootstrap');

//or

$projects = $client->api('org_projects')->all('twbs');
```

### List one project

```php
$project = $client->api('repo')->projects()->show($projectId);
```

### Create a project

> Requires [authentication](../security.md).

```php
$project = $client->api('repo')->projects()->create('twbs', 'bootstrap', array('name' => 'Project name'));
```

### Edit a project

> Requires [authentication](../security.md).

```php
$project = $client->api('repo')->project()->update($projectId, array('name' => 'New name'));
```

### Remove a project

> Requires [authentication](../security.md).

```php
$project = $client->api('repo')->projects()->deleteProject($projectId);
```
