## Repo / Actions / Variables API
[Back to the "Repos API"](../../repos.md) | [Back to the navigation](../../README.md)

### List repository variables

https://docs.github.com/rest/actions/variables#list-repository-variables

```php
$variables = $client->api('repo')->variables()->all('KnpLabs', 'php-github-api');
```

### Get a repository variable

https://docs.github.com/rest/actions/variables#get-a-repository-variable

```php
$variable = $client->api('repo')->variables()->show('KnpLabs', 'php-github-api', $variableName);
```

### Create a repository variable

https://docs.github.com/rest/actions/variables#create-a-repository-variable

```php
$client->api('repo')->variables()->create('KnpLabs', 'php-github-api', [
    'name' => $name,
    'value' => $value,
]);
```

### Update a repository variable

https://docs.github.com/rest/actions/variables#update-a-repository-variable

```php
$client->api('repo')->variables()->update('KnpLabs', 'php-github-api', $variableName, [
    'name' => $name,
    'value' => $value,
]);
```

### Delete a repository variable

https://docs.github.com/rest/actions/variables#delete-a-repository-variable

```php
$client->api('repo')->variables()->remove('KnpLabs', 'php-github-api', $variableName);
```
