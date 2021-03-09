## Repo / Secrets API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

### List repository secrets

https://docs.github.com/en/rest/reference/actions#list-repository-secrets

```php
$secrets = $client->api('repo')->secrets()->all('KnpLabs', 'php-github-api');
```

### Get a repository secret

https://docs.github.com/en/rest/reference/actions#get-a-repository-secret

```php
$secret = $client->api('repo')->secrets()->show('KnpLabs', 'php-github-api', $secretName);
```

### Create a repository secret

https://docs.github.com/en/rest/reference/actions#create-or-update-a-repository-secret

```php
$client->api('repo')->secrets()->create('KnpLabs', 'php-github-api', $secretName, [
    'encrypted_value' => $encryptedValue,
]);                                                                                                     $client->api('repo')->secrets()->all();
```

### Update a repository secret

https://docs.github.com/en/rest/reference/actions#create-or-update-a-repository-secret

```php
$client->api('repo')->secrets()->update('KnpLabs', 'php-github-api', $secretName, [
    'key_id' => $keyId, 'encrypted_value' => $encryptedValue,
]);
```

### Delete a repository secret

https://docs.github.com/en/rest/reference/actions#delete-a-repository-secret

```php
$client->api('repo')->secrets()->remove('KnpLabs', 'php-github-api', $secretName);
```

### Get a repository public key

https://docs.github.com/en/rest/reference/actions#get-a-repository-public-key

```php
$publicKey = $client->api('repo')->secrets()->publicKey('KnpLabs', 'php-github-api');
```
