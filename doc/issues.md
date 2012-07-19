## Issues API
[Back to the navigation](index.md)

Listing issues, searching, editing and closing your projects issues.
Wrap [GitHub Issue API](http://developer.github.com/v3/issues/).

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

```php
<?php

$client->authenticate();
$client->api('issue')->create('KnpLabs', 'php-github-api', array('title' => 'The issue title', 'body' => 'The issue body');
```

Creates a new issue in the repo "php-github-api" of the user "KnpLabs".
The issue is assigned to the authenticated user. Requires authentication.
Returns an array of information about the issue.

### Close an issue

```php
<?php

$client->authenticate();
$client->api('issue')->update('KnpLabs', 'php-github-api', 4, array('state' => 'closed'));
```

Closes the fourth issue of the repo "php-github-api" of the user "KnpLabs". Requires authentication.
Returns an array of information about the issue.

### Reopen an issue

```php
<?php

$client->authenticate();
$client->api('issue')->update('KnpLabs', 'php-github-api', 4, array('state' => 'open'));
```

Reopens the fourth issue of the repo "php-github-api" of the user "ornicar". Requires authentication.
Returns an array of information about the issue.

### Update an issue

```php
<?php

$client->authenticate();
$client->api('issue')->update('KnpLabs', 'php-github-api', 4, array('body' => 'The new issue body'));
```

Updates the fourth issue of the repo "php-github-api" of the user "KnpLabs". Requires authentication.
Available attributes are title and body.
Returns an array of information about the issue.

### List an issue comments

```php
<?php

$comments = $client->api('issue')->comments()->all('KnpLabs', 'php-github-api', 4);
```

List an issue comments by username, repo and issue number.
Returns an array of issues.

### Add a comment on an issue

```php
<?php

$client->authenticate();
$client->api('issue')->comments()->create('KnpLabs', 'php-github-api', 4, array('body' => 'My new comment'));
```

Add a comment to the issue by username, repo and issue number.
The comment is assigned to the authenticated user. Requires authentication.

### List project labels

```php
<?php

$labels = $client->api('issue')->labels()->all('KnpLabs', 'php-github-api');
```

List all project labels by username and repo.
Returns an array of project labels.

### Add a label on an issue

```php
<?php

$client->authenticate();
$client->api('issue')->labels()->add('KnpLabs', 'php-github-api', 4, 'label name');
```

Add a label to the issue by username, repo, label name and issue number. Requires authentication.
If the label is not yet in the system, it will be created.
Returns an array of the issue labels.

### Remove a label from an issue

```php
<?php

$client->authenticate();
$client->api('issue')->labels()->remove('KnpLabs', 'php-github-api', 4, 'label name');
```

Remove a label from the issue by username, repo, label name and issue number. Requires authentication.
Returns an array of the issue labels.

### Search issues matching a label

```php
<?php

$client->api('issue')->all('KnpLabs', 'php-github-api', array('labels' => 'label name'));
```

Returns an array of issues matching the given label.
