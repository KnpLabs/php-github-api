## Gists / Comments API

[Back to the "Gists API"](../gists.md) | [Back to the navigation](../README.md)

Wraps [GitHub Issue Comments API](http://developer.github.com/v3/gists/comments/).

### List a gist comments

```php
// for gist https://gist.github.com/danvbe/4476697
$comments = $client->api('gist')->comments()->all('4476697');
```

* `4476697` : the id of the gist

### Show a gist comment

```php
$comment = $client->api('gist')->comments()->show('4476697', '779656');
```

* `4476697` : the id of the gist
* `779656` : the id of the comment

### Create a gist comment

```php
$client->api('gist')->comments()->create('4476697', 'Hello World');
```

* `4476697` : the id of the gist
* `Hello World` : the body of the comment

### Update a gist comment

```php
$client->api('gist')->comments()->create('4476697', '123456', 'Hello Dolly');
```

* `4476697` : the id of the gist
* `123456` : the id of the comment
* `Hello Dolly` : the body of the updated comment

### Remove a gist comment

```php
$client->api('gist')->comments()->remove('4476697', '123456');
```

* `4476697` : the id of the gist
* `123456` : the id of the comment 
