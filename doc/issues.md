## Issues API
[Back to the navigation](README.md)

Listing issues, searching, editing and closing your projects issues.
Wraps [GitHub Issue API](http://developer.github.com/v3/issues/).

Additional APIs:
* [Comments](issue/comments.md)
* [Labels](issue/labels.md)
* [Milestones](issue/milestones.md)

### List issues in a project

```php
$issues = $client->api('issue')->all('KnpLabs', 'php-github-api', array('state' => 'open'));
```

Returns an array of issues.

### Search issues in a project

```php
$issues = $client->api('issue')->find('KnpLabs', 'php-github-api', 'closed', 'bug');
```

Returns an array of closed issues matching the "bug" term. For more complex searches, use the [search api](search.md) which supports the advanced GitHub search syntax.

### Get information about an issue

```php
$issue = $client->api('issue')->show('KnpLabs', 'php-github-api', 1);
```

Returns an array of information about the issue.

### Open a new issue

> Requires [authentication](security.md).

```php
$client->api('issue')->create('KnpLabs', 'php-github-api-example', array('title' => 'The issue title', 'body' => 'The issue body'));
```

Creates a new issue in the repo "php-github-api-example" (the repository in this example does not exist) of the user "KnpLabs". The issue is assigned to the authenticated user.
Returns an array of information about the issue.

### Close an issue

> Requires [authentication](security.md).

```php
$client->api('issue')->update('KnpLabs', 'php-github-api', 4, array('state' => 'closed'));
```

Closes the fourth issue of the repo "php-github-api" of the user "KnpLabs".
Returns an array of information about the issue.

### Reopen an issue

> Requires [authentication](security.md).

```php
$client->api('issue')->update('KnpLabs', 'php-github-api', 4, array('state' => 'open'));
```

Reopens the fourth issue of the repo "php-github-api" of the user "KnpLabs".
Returns an array of information about the issue.

### Update an issue

> Requires [authentication](security.md).

```php
$client->api('issue')->update('KnpLabs', 'php-github-api', 4, array('body' => 'The new issue body'));
```

Updates the fourth issue of the repo "php-github-api" of the user "KnpLabs". Available attributes are title and body.
Returns an array of information about the issue.

### Search issues matching a label

```php
$client->api('issue')->all('KnpLabs', 'php-github-api', array('labels' => 'label name'));
```

Returns an array of issues matching the given label.

### Lock an issue discussion

```php
$client->api('issue')->lock('KnpLabs', 'php-github-api', 4);
```

### Unlock an issue discussion

```php
$client->api('issue')->unlock('KnpLabs', 'php-github-api', 4);
```
