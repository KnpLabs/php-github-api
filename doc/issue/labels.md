## Issues / Labels API
[Back to the "Issues API"](../issues.md) | [Back to the navigation](index.md)

Wraps [GitHub Issue Labels API](http://developer.github.com/v3/issues/labels/).

### List project labels

```php
<?php

$labels = $client->api('issue')->labels()->all('KnpLabs', 'php-github-api');
```

List all project labels by username and repo.
Returns an array of project labels.

### Add a label on an issue

> Requires authentication.

```php
<?php

$client->authenticate();
$labels = $client->api('issue')->labels()->add('KnpLabs', 'php-github-api', 4, 'label name');
```

Add a label to the issue by username, repo, issue number label name and. If the label is not yet in
the system, it will be created.
Returns an array of the issue labels.

### Replace all labels for an issue

> Requires authentication.

```php
<?php

$client->authenticate();
$client->api('issue')->labels()->replace('KnpLabs', 'php-github-api', 4, array('new label name'));
```

Replace a label for an issue: by username, repo, issue number and array of labels.

### Remove all labels fom an issue

> Requires authentication.

```php
<?php

$client->authenticate();
$client->api('issue')->labels()->replace('KnpLabs', 'php-github-api', 4);
```

Removal of all labels for the issue by username, repo, issue number.

### Remove a label from an issue

> Requires authentication.

```php
<?php

$client->authenticate();
$client->api('issue')->labels()->remove('KnpLabs', 'php-github-api', 4, 'label name');
```

Remove a label from the issue by username, repo, issue number and label name.
