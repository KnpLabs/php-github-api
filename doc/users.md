## Users API
[Back to the navigation](index.md)

Searching users, getting user information and managing authenticated user account information.
Wrap [GitHub User API](http://developer.github.com/v3/users/).

### Search for users by keyword

```php
$users = $client->api('user')->find('KnpLabs');
```

Returns an array of found users.

### Get information about a user

```php
$user = $client->api('user')->show('KnpLabs');
```

Returns an array of information about the user.

### Update user informations

> Requires [authentication](security.md).

Change user attributes: name, email, blog, company, location.

```php
$client->api('current_user')->update(array(
    'location' => 'France',
    'blog'     => 'http://diem-project.org/blog'
));
```

Returns an array of information about the user.

### Get users that a specific user is following

```php
$users = $client->api('user')->following('KnpLabs');
```

Returns an array of followed users.

For authenticated user use.

> Requires [authentication](security.md).

```php
$users = $client->api('current_user')->follow()->all();
```

### Get users following a specific user

```php
$users = $client->api('user')->followers('KnpLabs');
```

Returns an array of following users.

For authenticated user use.

> Requires [authentication](security.md).

```php
$users = $client->api('current_user')->followers();
```

### Follow a user

> Requires [authentication](security.md).

Make the authenticated user follow a user.

```php
$client->api('current_user')->follow()->follow('symfony');
```

Returns an array of followed users.

### Unfollow a

> Requires [authentication](security.md).

Make the authenticated user unfollow a user.

```php
$client->api('current_user')->follow()->unfollow('symfony');
```

Returns an array of followed users.

### Get repos that a specific user is watching

```php
$users = $client->api('user')->watched('ornicar');
```

For authenticated user use.

> Requires [authentication](security.md).

```php
$users = $client->api('current_user')->watched();
```

Returns an array of watched repos.

### Get the authenticated user emails

> Requires [authentication](security.md).

```php
$emails = $client->api('current_user')->emails()->all();
```

Returns an array of the authenticated user emails.

### Add an email to the authenticated user

> Requires [authentication](security.md).

```php
$emails = $client->api('current_user')->emails()->add('my-email@provider.org');
// or add few emails at once
$emails = $client->api('current_user')->emails()->add(array('first@provider.org', 'second@provider.org'));
```

Returns an array of the authenticated user emails.

### Remove an email from the authenticated user

> Requires [authentication](security.md).

```php
$emails = $client->api('current_user')->emails()->remove('my-email@provider.org');
// or remove few emails at once
$emails = $client->api('current_user')->emails()->remove(array('first@provider.org', 'second@provider.org'));
```

Return an array of the authenticated user emails.
