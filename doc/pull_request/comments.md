## Pull Requests / Review Comments API
[Back to the "Pull Requests API"](../pull_requests.md) | [Back to the navigation](../index.md)

Review Comments are comments on a portion of the unified diff. These are separate from Commit Comments (which
are applied directly to a commit, outside of the Pull Request view), and Issue Comments (which do not reference
a portion of the unified diff).

Wraps [GitHub PR Review Comments API](http://developer.github.com/v3/pulls/comments/).

> **Note:**
> New comments are assigned to the [authenticated](../security.md) user.

### List all comments for selected pull request

```php
$comments = $client->api('pull_request')->comments()->all('KnpLabs', 'php-github-api', 8);
```

``$comments`` contains an array of review comments in selected pull-request for this repository.

### Show one comment

```php
$comment = $client->api('pull_request')->comments()->show('KnpLabs', 'php-github-api', 15);
```

The last parameter of this call, Review Comment ID.

### Populated with full details

> Requires [authentication](../security.md).

```php
$comment = $client->api('pull_request')->comments()->create('KnpLabs', 'php-github-api', 8, array(
    'body'      => 'Nice change',
    'commit_id' => 'da6e3879b5658908c3cdf562dacbc458675586ca',
    'path'      => 'README.markdown',
    'position'  => 37,
    'line'      => 31
);
```

This returns the details of the comment.

### Populated as a reply to another comment

> Requires [authentication](../security.md).

```php
$comment = $client->api('pull_request')->comments()->create('KnpLabs', 'php-github-api', 8, array(
    'body'        => 'Yeah! Really nice change',
    'in_reply_to' => 2
);
```

This returns the details of the comment.

### Update comment details

> Requires [authentication](../security.md).

```php
$comment = $client->api('pull_request')->comments()->update('KnpLabs', 'php-github-api', 2, array(
    'body' => 'Hell Yeah! Awesome change!'
);
```

This returns the details of the updated comment.

### Remove a review comment from an pull request

> Requires [authentication](../security.md).

```php
$client->api('pull_request')->comments()->remove('KnpLabs', 'php-github-api', 2);
```

Remove a comment from the pull request by username, repo, comment number.
