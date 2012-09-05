## Gists API
[Back to the navigation](index.md)

Creating, editing, deleting and listing gists. Wraps [GitHub Gists API](http://developer.github.com/v3/gists/).

#### List all public gists.

```php
$gists = $github->api('gists')->all('public');
```

#### List the authenticated user’s starred gists.

> Requires [authentication](security.md).

```php
$gists = $github->api('gists')->all('starred');
```

Requires authentication.

#### List the authenticated user’s gists or if called anonymously, this will return all public gists.

> Requires [authentication](security.md) to list your gists.

```php
$gists = $github->api('gists')->all();
```

#### Get a single gist

```php
$gist = $github->api('gists')->show(1);
```

#### Create a gist

```php
$data = array(
    'files' => array(
        'filename.txt' => array(
            'content' => 'txt file content'
        ),
    ),
    'public' => true,
    'description' => 'This is an optional description'
);

$gist = $github->api('gists')->create($data);
```

Creates and returns a public gist.

#### Update a gist

You can update ``description``.

```php
$data = array(
    'description' => 'This is new description'
);

$gist = $github->api('gists')->update($data);
```

You can update ``content`` of a previous file's version.

```php
$data = array(
    'files' => array(
        'filename.txt' => array(
            'content' => 'updated txt file content'
        ),
    ),
);
$gist = $github->api('gists')->update(1234, $data);
```

You can update the ``filename`` of a previous file's version.

```php
$data = array(
    'files' => array(
        'filename.txt' => array(
            'filename' => 'new-filename.txt'
        ),
    ),
);
$gist = $github->api('gists')->update(1234, $data);
```

You can add a new file to the gist.

```php
$data = array(
    'files' => array(
        'new-filename.php' => array(
            'content' => 'a new file content'
        ),
    ),
);
$gist = $github->api('gists')->update(1234, $data);
```

You can remove a file from the gist.

```php
$data = array(
    'files' => array(
        'filename.txt' => null,
    ),
);
$gist = $github->api('gists')->update(1234, $data);
```

#### Delete a gist

```php
$gist = $github->api('gists')->remove(1234);
```
