## References API
[Back to the navigation](../README.md)


### List all references
```php
$references = $client->api('gitData')->references()->all('KnpLabs', 'php-github-api');
```

### Show a reference

```php
$reference = $client->api('gitData')->references()->show('KnpLabs', 'php-github-api', 'heads/featureA');
```

### Create a reference

```php
$referenceData = ['ref' => 'refs/heads/featureA', 'sha' => '839e5185da9434753db47959bee16642bb4f2ce4'];
$reference = $client->api('gitData')->references()->create('KnpLabs', 'php-github-api', $referenceData);
```

### Update a reference

```php
$referenceData = ['sha' => '839e5185da9434753db47959bee16642bb4f2ce4', 'force' => false ]; //Force is default false
$reference = $client->api('gitData')->references()->update('KnpLabs', 'php-github-api', 'heads/featureA', $referenceData);
```

### Delete a reference

```php
$client->api('gitData')->references()->remove('KnpLabs', 'php-github-api', 'heads/featureA');
```

### List all branches
```php
$references = $client->api('gitData')->references()->branches('KnpLabs', 'php-github-api');
```

### List all tags
```php
$references = $client->api('gitData')->references()->tags('KnpLabs', 'php-github-api');
```