## Authorizations API
[Back to the navigation](index.md)

Creating, deleting and listing authorizations. Wraps [GitHub Authorizations API](http://developer.github.com/v3/oauth/).

#### List all authorizations.

```php
$authorizations = $github->api('authorizations')->all();
```

#### Get a single authorization

```php
$authorization = $github->api('authorizations')->show(1);
```

#### Create a authorization

```php
$data = array(
    'note' => 'This is an optional description'
);

$authorization = $github->api('authorizations')->create($data);
```

Creates and returns a authorization.

#### Update a authorization

You can update ``note``.

```php
$data = array(
    'note' => 'This is new note'
);

$authorization = $github->api('authorizations')->update(1234, $data);
```

#### Delete a authorization

```php
$authorization = $github->api('authorizations')->remove(1234);
```

#### Check a authorization

```php
$authorization = $github->api('authorizations')->check(1234, 'token');
```
