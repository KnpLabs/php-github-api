## Environment / Secrets API
[Back to the "Environments API"](../environments.md) | [Back to the navigation](../README.md)

### List environment secrets

https://docs.github.com/en/rest/actions/secrets?apiVersion=2022-11-28

```php
$secrets = $client->environment()->secrets()->all($repoId, $envName);
```

### Get an environment secret

https://docs.github.com/en/rest/actions/secrets?apiVersion=2022-11-28#get-an-environment-secret

```php
$secret = $client->environment()->secrets()->show($repoId, $envName, $secretName);
```

### Create or Update an environment secret

https://docs.github.com/en/rest/actions/secrets?apiVersion=2022-11-28#create-or-update-an-environment-secret

```php
$client->environment()->secrets()->createOrUpdate($repoId, $envName, $secretName, [
    'encrypted_value' => $encryptedValue,
    'key_id' => $key_id
]);
```

### Delete an environment secret

https://docs.github.com/en/rest/reference/actions#delete-an-organization-secret

```php
$client->environment()->secrets()->remove($repoId, $envName, $secretName);
```

### Get an environment public key

https://docs.github.com/en/rest/reference/actions#get-an-organization-public-key

```php
$client->environment()->secrets()->publicKey($repoId, $envName);
```

