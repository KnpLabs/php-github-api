## Issues / Comments API
[Back to the "Issues API"](../issues.md) | [Back to the navigation](index.md)

Wraps [GitHub Issue Comments API](http://developer.github.com/v3/issues/comments/).

### List an issue comments

```php
<?php

$comments = $client->api('issue')->comments()->all('KnpLabs', 'php-github-api', 4);
```

List an issue comments by username, repo and issue number.
Returns an array of issues.

### Add a comment on an issue

> **Note:**
> New comments are assigned to the authenticated user.

> Requires authentication.

```php
<?php

$client->authenticate();
$client->api('issue')->comments()->create('KnpLabs', 'php-github-api', 4, array('body' => 'My new comment'));
```

Add a comment to the issue by username, repo and issue number and array with comment data: `body`
and optionally `title`.
