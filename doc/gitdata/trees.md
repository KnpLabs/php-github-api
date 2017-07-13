## Trees API
[Back to the navigation](../README.md)

### Show a tree

```php
$tree = $client->api('gitData')->trees()->show('KnpLabs', 'php-github-api', '839e5185da9434753db47959bee16642bb4f2ce4');
```

### Create a tree

```php
$treeData = [
    'base_tree' => '839e5185da9434753db47959bee16642bb4f2ce4',
    'tree' => [
        [
            'path' => 'README.md',
            'mode' => '100644',
            'type' => 'blob',
            'content' => 'Updated Readme file'
        ]
    ]
];
$tree = $client->api('gitData')->trees()->create('KnpLabs', 'php-github-api', $treeData);
```