## Repo / Cards API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

This api is currently only available to developers in Early Access. To access the API during the Early Access period, 
you must provide a custom media type in the Accept header.

```php
$client->api('repo')->projects()->columns()->cards()->configure();
```

### List all cards of a column

```php
$cards = $client->api('repo')->projects()->columns()->cards()->all('twbs', 'bootstrap', $columnId);
```

### List one card

```php
$card = $client->api('repo')->projects()->columns()->cards()->show('twbs', 'bootstrap', $cardId);
```

### Create a card

> Requires [authentication](../security.md).

```php
$card = $client->api('repo')->projects()->columns()->cards()->create('twbs', 'bootstrap', $columnId, array('content_type' => 'Issue', 'content_id' => '452'));
```

### Edit a card

> Requires [authentication](../security.md).

```php
$card = $client->api('repo')->project()->columns()->cards()->update('twbs', 'bootstrap', $cardId, array('note' => 'card note'));
```

### Remove a card

> Requires [authentication](../security.md).

```php
$card = $client->api('repo')->projects()->columns()->cards()->deleteCard('twbs', 'bootstrap', $cardId);
```

### Move a card

> Requires [authentication](../security.md).

```php
$card = $client->api('repo')->projects()->columns()->cards()->move('twbs', 'bootstrap', $cardId, array('position' => 'top));
```
