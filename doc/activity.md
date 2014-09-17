## Activity API (incomplete)
[Back to the navigation](index.md)

Access to Starring and Watching a Repository for authenticated users.
Wrap [GitHub Activity API](https://developer.github.com/v3/activity/).

> No authentication required.

### Get repos that a specific user has starred

```php
$users = $client->api('user')->starred('ornicar');
```

Returns an array of starred repos.

> Requires [authentication](security.md).

### Get repos that a authenticated user has starred

```php
$activity = $client->api('current_user')->starred()->all();
```
Returns an array of starred repos.

### Check if authenticated user has starred a specific repo

```php
$owner = "KnpLabs";
$repo = "php-github-api";
$activity = $client->api('current_user')->starred()->check($owner, $repo);
```
Throws an Exception with code 404 in case that the repo is not starred by the authenticated user or NULL in case that it is starred by the authenticated user.

### Star a specific repo for authenticated user

```php
$owner = "KnpLabs";
$repo = "php-github-api";
$activity = $client->api('current_user')->starred()->star($owner, $repo);
```
Throws an Exception in case of failure or NULL in case of success.

### Unstar a specific repo for authenticated user

```php
$owner = "KnpLabs";
$repo = "php-github-api";
$activity = $client->api('current_user')->starred()->unstar($owner, $repo);
```
Throws an Exception in case of failure or NULL in case of success.