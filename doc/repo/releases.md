## Repo / Releases API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../index.md)

This Github API Endpoint is currently undocumented because it's new, but works just fine.


### List all releases

```php
$releases = $client->api('repo')->releases()->all('twbs', 'bootstrap');
```

### List one release

```php
$release = $client->api('repo')->releases()->show('twbs', 'bootstrap', $id);
```

### Create a release
```php
$release = $client->api('repo')->releases()->create('twbs', 'bootstrap', array('tag_name' => 'v1.1'));
```

### Edit a release
```php
$release = $client->api('repo')->releases()->edit('twbs', 'bootstrap', $id, array('name' => 'New release name'));
```

### Remove a release

This works, but isn't thoroughly tested, use at your own risk.

```php
$response = $client->api('repo')->releases()->remove('twbs', 'bootstrap', $id);
```
