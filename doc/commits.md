## Commits API
[Back to the navigation](index.md)

Getting information on specific commits, the diffs they introduce, the files they've changed.
Wrap [GitHub Commit API](http://developer.github.com/v3/git/commits/).

### List commits in a branch

```php
<?php

$commits = $client->api('repo')->commits()->all('KnpLabs', 'php-github-api', array('sha' => 'master'));
```

Returns an array of commits.

### List commits for a file

```php
<?php

$commits = $client->api('repo')->commits()->all('KnpLabs', 'php-github-api', array('sha' => 'master', 'path' => 'README'));
```

Returns an array of commits.

### Get a single commit

```php
<?php

$commit = $client->api('repo')->commits()->show('KnpLabs', 'php-github-api', '839e5185da9434753db47959bee16642bb4f2ce4');
```

Returns a single commit.

### Compare commits

```php
<?php

$commit = $client->api('repo')->commits()->compare('KnpLabs', 'php-github-api', '839e5185da9434753db47959bee16642bb4f2ce4', 'b24a89060ca3f337c9b8c4fd2c929f60a5f2e33a');
```

Returns an array of commits.
