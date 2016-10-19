## Issues / Comments API
[Back to the "Issues API"](../issues.md) | [Back to the navigation](../README.md)

Wraps [GitHub Issue Comments API](http://developer.github.com/v3/issues/comments/).

### List an issue comments

```php
$comments = $client->api('issue')->comments()->all('KnpLabs', 'php-github-api', 4);
```

* `KnpLabs` : the owner of the repository
* `php-github-api` : the name of the repository
* `4` : the issue number
* You can select another page of comments using one more parameter (default: 1)

Returns an array of comments.


### Show an issue comment

```php
$comment = $client->api('issue')->comments()->show('KnpLabs', 'php-github-api', 33793831);
```

* `KnpLabs` : the owner of the repository
* `php-github-api` : the name of the repository
* `33793831` : the id of the comment


### Add a comment on an issue

> **Note:**
> New comments are assigned to the authenticated user.

> Requires [authentication](../security.md).

```php
$client->api('issue')->comments()->create('KnpLabs', 'php-github-api', 4, array('body' => 'My new comment'));
```

* `KnpLabs` : the owner of the repository
* `php-github-api` : the name of the repository
* `4` : the issue number
* You can set a `body` and optionally a `title`


### Update a comment on an issue

> **Note:**

> Requires [authentication](../security.md).

```php
$client->api('issue')->comments()->update('KnpLabs', 'php-github-api', 33793831, array('body' => 'My updated comment'));
```

* `KnpLabs` : the owner of the repository
* `php-github-api` : the name of the repository
* `33793831` : the id of the comment

### Remove a comment on an issue

> **Note:**

> Requires [authentication](../security.md).

```php
$client->api('issue')->comments()->remove('KnpLabs', 'php-github-api', 33793831);
```

* `KnpLabs` : the owner of the repository
* `php-github-api` : the name of the repository
* `33793831` : the id of the comment
