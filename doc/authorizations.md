## Authorizations API
[Back to the navigation](README.md)

Creating, deleting and listing authorizations. Wraps [GitHub Authorizations API](http://developer.github.com/v3/oauth_authorizations/).

#### List all authorizations.

```php
$authorizations = $github->api('authorizations')->all();
```

#### Get a single authorization

```php
$authorization = $github->api('authorizations')->show(1);
```

#### Create an authorization

```php
$data = array(
    'note' => 'This is an optional description'
);

$authorization = $github->api('authorizations')->create($data);
```

Creates and returns an authorization.

#### Update an authorization

You can update ``note``.

```php
$data = array(
    'note' => 'This is new note'
);

$authorization = $github->api('authorizations')->update(1234, $data);
```

#### Delete an authorization

```php
$authorization = $github->api('authorizations')->remove(1234);
```

#### Check an authorization

```php
$authorization = $github->api('authorizations')->check(1234, 'token');
```

#### Reset an authorization

```php
$authorization = $github->api('authorizations')->reset(1234, 'token');
```

#### Revoke an authorization

```php
$github->api('authorizations')->revoke(1234, 'token');
```

#### Revoke all authorizations

```php
$github->api('authorizations')->revokeAll(1234);
```
