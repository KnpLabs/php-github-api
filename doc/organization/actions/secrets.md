## Organization / Secrets API
[Back to the "Organization API"](../organization.md) | [Back to the navigation](../README.md)

### List organization secrets

https://docs.github.com/en/rest/reference/actions#list-organization-secrets

```php
$secrets = $client->organization()->secrets()->all('KnpLabs');
```

### Get an organization secret

https://docs.github.com/en/rest/reference/actions#get-an-organization-secret

```php
$secret = $client->organization()->secrets()->show('KnpLabs', $secretName);
```

### Create an organization secret

https://docs.github.com/en/rest/reference/actions#create-or-update-an-organization-secret

```php
$client->organization()->secrets()->create('KnpLabs', $secretName, [
    'encrypted_value' => $encryptedValue,
    'visibility' => $visibility,
    'selected_repository_ids' => $selectedRepositoryIds,
]);
```

### Update an organization secret

https://docs.github.com/en/rest/reference/actions#create-or-update-an-organization-secret

```php
$client->organization()->secrets()->update('KnpLabs', $secretName, [
    'key_id' => 'keyId',
    'encrypted_value' => 'encryptedValue',
    'visibility' => 'private',
]);
```

### Delete an organization secret

https://docs.github.com/en/rest/reference/actions#delete-an-organization-secret

```php
$client->organization()->secrets()->remove('KnpLabs', $secretName);
```

### List selected repositories for organization secret

https://docs.github.com/en/rest/reference/actions#list-selected-repositories-for-an-organization-secret

```php
$client->organization()->secrets()->selectedRepositories('KnpLabs', $secretName);
```

### Set selected repositories for an organization secret

https://docs.github.com/en/rest/reference/actions#set-selected-repositories-for-an-organization-secret

```php
$client->organization()->secrets()->setSelectedRepositories('KnpLabs', 'secretName', [
    'selected_repository_ids' => [1, 2, 3],
]);
```

### Remove selected repository from an organization secret

https://docs.github.com/en/rest/reference/actions#remove-selected-repository-from-an-organization-secret

```php
$client->organization()->secrets()->addSecret('KnpLabs', $repositoryId, $secretName);
```

### Get an organization public key

https://docs.github.com/en/rest/reference/actions#get-an-organization-public-key

```php
$client->organization()->secrets()->publicKey('KnpLabs');
```

