## Commits API
[Back to the navigation](../README.md)

### Show a commit

```php
$commit = $client->api('gitData')->commits()->show('KnpLabs', 'php-github-api', '839e5185da9434753db47959bee16642bb4f2ce4');
```

### Create a commit

```php
$commitData = ['message' => 'Upgrading documentation', 'tree' => $treeSHA, 'parents' => [$parentCommitSHA]];
$commit = $client->api('gitData')->commits()->create('KnpLabs', 'php-github-api', $commitData);
```