## Current user / Public Keys API
[Back to the navigation](../README.md)

Wraps [GitHub User Public Keys API](https://developer.github.com/v3/users/keys/#public-keys).

### List your public keys

```php
$keys = $client->me()->keys()->all();
```

Returns a list of public keys for the authenticated user.

### Shows a public key for the authenticated user.

```php
$key = $client->me()->keys()->show(1234);
```

### Add a public key to the authenticated user.

> Requires [authentication](../security.md).

```php
$key = $client->me()->keys()->create(array('title' => 'key title', 'key' => 12345));
```

Adds a key with title 'key title' to the authenticated user and returns a the created key for the user.

### Remove a public key from the authenticated user.

> Requires [authentication](../security.md).

```php
$client->me()->keys()->remove(12345);
```
