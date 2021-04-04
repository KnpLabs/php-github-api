## Repo / Releases API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

### List all assets by release

```php
$assets = $client->api('repo')->releases()->assets()->all('twbs', 'bootstrap', $releaseId);
```

### List one asset

```php
$asset = $client->api('repo')->releases()->assets()->show('twbs', 'bootstrap', $assetId);
```

### Download binary content of asset

```php
$asset = $client->api('repo')->releases()->assets()->show('twbs', 'bootstrap', $assetId, true);
```

### Create an asset

```php
$asset = $client->api('repo')->releases()->assets()->create('twbs', 'bootstrap', $releaseId, $name, $contentType, $content);
```

### Edit an asset

```php
$asset = $client->api('repo')->releases()->assets()->edit('twbs', 'bootstrap', $assetId, array('name' => 'New name'));
```

### Remove an asset

```php
$asset = $client->api('repo')->releases()->assets()->remove('twbs', 'bootstrap', $assetId);
```
