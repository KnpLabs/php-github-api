## Repo / Custom Properties API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

For extended info see the [GitHub documentation](https://docs.github.com/en/rest/reference/repos#custom-properties-for-a-repository)

### List custom properties for a repository

```php
$properties = $client->api('repo')->properties()->all('twbs', 'bootstrap');
```

### Get a custom property for a repository

```php
$property = $client->api('repo')->properties()->show('twbs', 'bootstrap', $propertyName);
```


### Update a custom property for a repository

```php
$parameters = [
    'property_name' => 'foo',
    'value' => 'bar'
]

$property = $client->api('repo')->properties()->update('twbs', 'bootstrap', $params);
```
