## Issues / Labels API
[Back to the "Issues API"](../issues.md) | [Back to the navigation](../README.md)

Wraps [GitHub Issue Labels API](http://developer.github.com/v3/issues/labels/).

### List project labels

```php
$labels = $client->api('issue')->labels()->all('KnpLabs', 'php-github-api');
```

List all project labels by username and repo.
Returns an array of project labels.

### Get a single label

```php
$label = $client->api('issue')->labels()->show('KnpLabs', 'php-github-api', 'label1');
```

### Create a label

```php
$labels = $client->api('issue')->labels()->create('KnpLabs', 'php-github-api', array(
    'name' => 'Bug',
    'color' => 'FFFFFF',
));
```

Create a new label in the repository.

### Update a label

```php
$labels = $client->api('issue')->labels()->update('KnpLabs', 'php-github-api', 'Enhancement', 'Feature', 'FFFFFF');
```

Update the label name and color.

### Delete a label

```php
$labels = $client->api('issue')->labels()->deleteLabel('KnpLabs', 'php-github-api', 'Bug');
```

Delete a new label from the repository.

### Add a label on an issue

> Requires [authentication](../security.md).

```php
$labels = $client->api('issue')->labels()->add('KnpLabs', 'php-github-api', 4, 'label name');
```

Add a label to the issue by username, repo, issue number label name and. If the label is not yet in
the system, it will be created.
Returns an array of the issue labels.

### Get all labels for an issue

```php
$label = $client->api('issue')->labels()->all('KnpLabs', 'php-github-api', 4);
```

### Replace all labels for an issue

> Requires [authentication](../security.md).

```php
$client->api('issue')->labels()->replace('KnpLabs', 'php-github-api', 4, array('new label name'));
```

Replace a label for an issue: by username, repo, issue number and array of labels.

### Remove all labels from an issue

> Requires [authentication](../security.md).

```php
$client->api('issue')->labels()->replace('KnpLabs', 'php-github-api', 4);
```

Removal of all labels for the issue by username, repo, issue number.

### Remove a label from an issue

> Requires [authentication](../security.md).

```php
$client->api('issue')->labels()->remove('KnpLabs', 'php-github-api', 4, 'label name');
```

Remove a label from the issue by username, repo, issue number and label name.
