## Users API
[Back to the navigation](index.md)

Searching users, getting user information and managing authenticated user account information.
Wrap [GitHub User API](http://developer.github.com/v3/users/).

### Search for users by keyword

```php
<?php

$users = $client->api('user')->find('KnpLabs');
```

Returns an array of found users.

### Get information about a user

```php
<?php

$user = $client->api('user')->show('KnpLabs');
```

Returns an array of information about the user.

### Update user informations

Change user attributes: name, email, blog, company, location. Requires authentication.

```php
<?php

$client->authenticate();
$client->api('current_user')->update(array(
    'location' => 'France',
    'blog'     => 'http://diem-project.org/blog'
));
```

Returns an array of information about the user.

### Get users that a specific user is following

```php
<?php

$users = $client->api('user')->following('KnpLabs');
```

Returns an array of followed users.

For authenticated user use:

```php
<?php

$client->authenticate();
$users = $client->api('current_user')->follow()->all();
```

### Get users following a specific user

```php
<?php

$users = $client->api('user')->followers('KnpLabs');
```

Returns an array of following users.

For authenticated user use:

```php
<?php

$client->authenticate();
$users = $client->api('current_user')->followers();
```

### Follow a user

Make the authenticated user follow a user. Requires authentication.

```php
<?php

$client->authenticate();
$client->api('current_user')->follow()->follow('symfony');
```

Returns an array of followed users.

### Unfollow a user

Make the authenticated user unfollow a user. Requires authentication.

```php
<?php

$client->authenticate();
$client->api('current_user')->follow()->unfollow('symfony');
```

Returns an array of followed users.

### Get repos that a specific user is watching

```php
<?php

$users = $client->api('user')->watched('ornicar');
```

For authenticated user use:

```php
<?php

$client->authenticate();
$users = $client->api('current_user')->watched();
```

Returns an array of watched repos.

### Get the authenticated user emails

```php
<?php

$client->authenticate();
$emails = $client->api('current_user')->emails()->all();
```

Returns an array of the authenticated user emails. Requires authentication.

### Add an email to the authenticated user

```php
<?php

$client->authenticate();
$emails = $client->api('current_user')->emails()->add('my-email@provider.org');
// or add few emails at once
$emails = $client->api('current_user')->emails()->add(array('first@provider.org', 'second@provider.org'));
```

Returns an array of the authenticated user emails. Requires authentication.

### Remove an email from the authenticated user

```php
<?php

$client->authenticate();
$emails = $client->api('current_user')->emails()->remove('my-email@provider.org');
// or remove few emails at once
$emails = $client->api('current_user')->emails()->remove(array('first@provider.org', 'second@provider.org'));
```

Return an array of the authenticated user emails. Requires authentication.
