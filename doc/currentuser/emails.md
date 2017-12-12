## Current user / Emails API
[Back to the navigation](../README.md)

Wraps [GitHub User Emails API](https://developer.github.com/v3/users/emails/#emails).

> Requires [authentication](../security.md).

### List email addresses for a user

```php
$emails = $client->currentUser()->emails()->all();
```

### List public email addresses for a user

```php
$emails = $client->currentUser()->emails()->allPublic();
```

### Add email address(es)

```php
$emails = $client->currentUser()->emails()->add(['email1', 'email2']);
```
### Delete email address(es)

```php
$client->currentUser()->emails()->remove(['email1', 'email2']);
```

### Toggle primary email visibility

```php
$primaryEmail = $client->currentUser()->emails()->toggleVisibility();
```
