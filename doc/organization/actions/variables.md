## Organization / Variables API
[Back to the "Organization API"](../organization.md) | [Back to the navigation](../README.md)

### List organization variables

https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#list-organization-variables

```php
$variables = $client->organization()->variables()->all('KnpLabs');
```

### Get an organization variable

https://docs.github.com/en/rest/reference/actions#get-an-organization-secret

```php
$variable = $client->organization()->variables()->show('KnpLabs', $variableName);
```

### Create an organization variable

https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#create-an-organization-variable

```php
$client->organization()->variables()->create('KnpLabs', [
    'name' => $name,
    'value' => $value,
    'visibility' => $visibility,
    'selected_repository_ids' => $selectedRepositoryIds,
]);
```

### Update an organization variable

https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#update-an-organization-variable

```php
$client->organization()->variables()->update('KnpLabs', $variableName, [
    'name' => $name,
    'value' => $value,
    'visibility' => $visibility,
    'selected_repository_ids' => $selectedRepositoryIds
]);
```

### Delete an organization variable

https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#delete-an-organization-variable

```php
$client->organization()->variables()->remove('KnpLabs', $variableName);
```

### List selected repositories for organization variable

https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#list-selected-repositories-for-an-organization-variable

```php
$client->organization()->variables()->selectedRepositories('KnpLabs', $variableName);
```

### Set selected repositories for an organization variable

https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#set-selected-repositories-for-an-organization-variable

```php
$client->organization()->variables()->setSelectedRepositories('KnpLabs', 'variableName', [
    'selected_repository_ids' => [1, 2, 3],
]);
```

### Add selected repository to an organization variable

https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#add-selected-repository-to-an-organization-variable

```php
$client->organization()->variables()->addRepository('KnpLabs', $repositoryId, $variableName);
```

### Remove selected repository from an organization variable

https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#remove-selected-repository-from-an-organization-variable

```php
$client->organization()->variables()->removeRepository('KnpLabs', $repositoryId, $variableName);
```

