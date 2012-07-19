## Issues API
[Back to the navigation](index.md)

Listing issues, searching, editing and closing your projects issues.
Wraps [GitHub Issue API](http://developer.github.com/v3/issues/).

Additional APIs:
* [Comments](issue/comments.md)
* [Labels](issue/labels.md)

### List issues in a project

```php
<?php

$issues = $client->api('issue')->all('KnpLabs', 'php-github-api', array('state' => 'open'));
```

Returns an array of issues.

### Search issues in a project

```php
<?php

$issues = $client->api('issue')->find('KnpLabs', 'php-github-api', 'closed', 'bug');
```

Returns an array of closed issues matching the "bug" term.

### Get information about an issue

```php
<?php

$issue = $client->api('issue')->show('KnpLabs', 'php-github-api', 1);
```

Returns an array of information about the issue.

### Open a new issue

> Requires authentication.

```php
<?php

$client->authenticate();
$client->api('issue')->create('KnpLabs', 'php-github-api', array('title' => 'The issue title', 'body' => 'The issue body');
```

Creates a new issue in the repo "php-github-api" of the user "KnpLabs". The issue is assigned to the authenticated user.
Returns an array of information about the issue.

### Close an issue

> Requires authentication.

```php
<?php

$client->authenticate();
$client->api('issue')->update('KnpLabs', 'php-github-api', 4, array('state' => 'closed'));
```

Closes the fourth issue of the repo "php-github-api" of the user "KnpLabs".
Returns an array of information about the issue.

### Reopen an issue

> Requires authentication.

```php
<?php

$client->authenticate();
$client->api('issue')->update('KnpLabs', 'php-github-api', 4, array('state' => 'open'));
```

Reopens the fourth issue of the repo "php-github-api" of the user "KnpLabs".
Returns an array of information about the issue.

### Update an issue

> Requires authentication.

```php
<?php

$client->authenticate();
$client->api('issue')->update('KnpLabs', 'php-github-api', 4, array('body' => 'The new issue body'));
```

Updates the fourth issue of the repo "php-github-api" of the user "KnpLabs". Available attributes are title and body.
Returns an array of information about the issue.

### Search issues matching a label

```php
<?php

$client->api('issue')->all('KnpLabs', 'php-github-api', array('labels' => 'label name'));
```

Returns an array of issues matching the given label.
