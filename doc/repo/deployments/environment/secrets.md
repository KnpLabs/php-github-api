## Environment / Secrets API
[Back to the "Environments API"](../environments.md) | [Back to the navigation](../README.md)

### List environment secrets

https://docs.github.com/rest/actions/secrets#list-environment-secrets

```php
$secrets = $client->environment()->secrets()->all($repoId, $envName);
```

### Get an environment secret

https://docs.github.com/rest/actions/secrets#get-an-environment-secret

```php
$secret = $client->environment()->secrets()->show($repoId, $envName, $secretName);
```

### Create or Update an environment secret

https://docs.github.com/rest/actions/secrets#create-or-update-an-environment-secret

```php
$client->environment()->secrets()->createOrUpdate($repoId, $envName, $secretName, [
    'encrypted_value' => $encryptedValue,
    'key_id' => $key_id
]);
```

### Delete an environment secret

https://docs.github.com/rest/actions/secrets#delete-an-environment-secret

```php
$client->environment()->secrets()->remove($repoId, $envName, $secretName);
```

### Get an environment public key

https://docs.github.com/rest/actions/secrets#get-an-environment-public-key

```php
$client->environment()->secrets()->publicKey($repoId, $envName);
```

