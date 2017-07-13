## Blobs API
[Back to the navigation](../README.md)

### Show a blob

```php
$blob = $client->api('gitData')->blobs()->show('KnpLabs', 'php-github-api', '839e5185da9434753db47959bee16642bb4f2ce4');
```

### Create a blob

```php
$blob = $client->api('gitData')->blobs()->create('KnpLabs', 'php-github-api', ['content' => 'Test content', 'encoding' => 'utf-8']);
```