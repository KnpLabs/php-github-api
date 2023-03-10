## Environment / Variables API
[Back to the "Environments API"](../environments.md) | [Back to the navigation](../README.md)

### List environment variables

https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#list-environment-variables

```php
$variables = $client->environment()->variables()->all($repoId, $envName);
```

### Get an environment variable

https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#get-an-environment-variable

```php
$variable = $client->environment()->variables()->show($repoId, $envName, $variableName);
```

### Create environment variable

https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#create-an-environment-variable

```php
$client->environment()->variables()->create($repoId, $envName, [
    'name' => $name,
    'value' => $value
]);
```

### Update environment variable

https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#update-an-environment-variable

```php
$client->environment()->variables()->update($repoId, $envName, $variableName, [
    'name' => $name,
    'value' => $value
]);
```

### Delete an environment variable

https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#delete-an-environment-variable

```php
$client->environment()->variables()->remove($repoId, $envName, $variableName);
```

