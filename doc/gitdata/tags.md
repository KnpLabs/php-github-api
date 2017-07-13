## Tags API
[Back to the navigation](../README.md)

### Show all tags

```php
$tags = $client->api('gitData')->tags()->all('KnpLabs', 'php-github-api');
```

### Show a tag

```php
$tag = $client->api('gitData')->tags()->show('KnpLabs', 'php-github-api', '839e5185da9434753db47959bee16642bb4f2ce4');
```

### Create a tag

```php
$tagData = [
    'tag' => 'v0.0.1',
    'message' => 'initial version',
    'object' => 'c3d0be41ecbe669545ee3e94d31ed9a4bc91ee3c',
    'type' => 'commit',
    'tagger' => [
        'name' => 'KnpLabs',
        'email' => 'hello@knplabs.com',
        'date' => '2017-06-17T14:53:35-07:00'
    ]
];

$tag = $client->api('gitData')->tags()->create('KnpLabs', 'php-github-api', $tagData);
```