## Repo / Cards API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

This api is currently only available to developers in Early Access. To access the API during the Early Access period, 
you must provide a custom media type in the Accept header.

Both repositories and organisations have projects. The api is only different for getting all project or retrieving a single project.
All the example use the repository projects column card api but this also works form the organization api (`$client->api('org_projects')->columns()->cards()`)


```php
$client->api('repo')->projects()->columns()->cards()->configure();
```

### List all cards of a column

```php
$cards = $client->api('repo')->projects()->columns()->cards()->all($columnId);
```

### List one card

```php
$card = $client->api('repo')->projects()->columns()->cards()->show($cardId);
```

### Create a card

> Requires [authentication](../security.md).

```php
$card = $client->api('repo')->projects()->columns()->cards()->create($columnId, array('content_type' => 'Issue', 'content_id' => '452'));
```

### Edit a card

> Requires [authentication](../security.md).

```php
$card = $client->api('repo')->project()->columns()->cards()->update($cardId, array('note' => 'card note'));
```

### Remove a card

> Requires [authentication](../security.md).

```php
$card = $client->api('repo')->projects()->columns()->cards()->deleteCard($cardId);
```

### Move a card

> Requires [authentication](../security.md).

```php
$card = $client->api('repo')->projects()->columns()->cards()->move($cardId, array('position' => 'top));
```
