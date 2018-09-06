## Activity API (incomplete)
[Back to the navigation](README.md)

Access to Starring and Watching a Repository for [non] authenticated users.
Wrap [GitHub Activity API](https://developer.github.com/v3/activity/).

> *** No authentication required. ***

### Get repos that a specific user has starred

```php
$users = $client->api('user')->starred('ornicar');
```

Returns an array of starred repos.

### Get repos that a specific user is watching

```php
$users = $client->api('user')->watched('ornicar');
```

Returns an array of watched repos.

> *** Requires [authentication](security.md). ***

### Get repos that a authenticated user has starred

```php
$activity = $client->api('current_user')->starring()->all();
```
Returns an array of starred repos.

### Get repos that a authenticated user has starred with creation date

Support for getting the star creation timestamp in the response, using the custom `Accept: application/vnd.github.v3.star+json` header.

```php
$activity = $client->api('current_user')->starring()->configure('star')->all();
```
Returns an array of starred repos, including the `created_at` attribute for every star.

### Check if authenticated user has starred a specific repo

```php
$owner = "KnpLabs";
$repo = "php-github-api";
$activity = $client->api('current_user')->starring()->check($owner, $repo);
```
Throws an Exception with code 404 in case that the repo is not starred by the authenticated user or NULL in case that it is starred by the authenticated user.

### Star a specific repo for authenticated user

```php
$owner = "KnpLabs";
$repo = "php-github-api";
$activity = $client->api('current_user')->starring()->star($owner, $repo);
```
Throws an Exception in case of failure or NULL in case of success.

### Unstar a specific repo for authenticated user

```php
$owner = "KnpLabs";
$repo = "php-github-api";
$activity = $client->api('current_user')->starring()->unstar($owner, $repo);
```
Throws an Exception in case of failure or NULL in case of success.


### Get repos that a authenticated user is watching

```php
$activity = $client->api('current_user')->watchers()->all();
```
Returns an array of watched repos.

### Check if authenticated user is watching a specific repo

```php
$owner = "KnpLabs";
$repo = "php-github-api";
$activity = $client->api('current_user')->watchers()->check($owner, $repo);
```
Throws an Exception with code 404 in case that the repo is not being watched by the authenticated user or NULL in case that it is being watched by the authenticated user.

### Watch a specific repo for authenticated user

```php
$owner = "KnpLabs";
$repo = "php-github-api";
$activity = $client->api('current_user')->watchers()->watch($owner, $repo);
```
Throws an Exception in case of failure or NULL in case of success.

### Stop watching a specific repo for authenticated user

```php
$owner = "KnpLabs";
$repo = "php-github-api";
$activity = $client->api('current_user')->watchers()->unwatch($owner, $repo);
```
Throws an Exception in case of failure or NULL in case of success.