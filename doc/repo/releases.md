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

### Remove a release

This works, but isn't thoroughly tested, use at your own risk.

```php
$response = $client->api('repo')->releases()->remove('twbs', 'bootstrap', $id);
```
