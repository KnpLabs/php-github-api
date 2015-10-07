## Repo / Releases API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

Provides information about releases for a repository. Wraps [GitHub Releases API](https://developer.github.com/v3/repos/releases/).


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
