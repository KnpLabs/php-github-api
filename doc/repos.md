## Repositories API
[Back to the navigation](index.md)

Searching repositories, getting repository information and managing repository information for authenticated users.
Wrap [GitHub Repo API](http://developer.github.com/v3/repos/). All methods are described on that page.

### Search repos by keyword

#### Simple search

```php
<?php

$repos = $client->api('repo')->find('symfony');
```

Returns a list of repositories.

#### Advanced search

You can filter the results by language. It takes the same values as the language drop down on [http://github.com/search](http://github).

```php
<?php

$repos = $client->api('repo')->find('chess', array('language' => 'php'));
```

You can specify the page number:

```php
<?php

$repos = $client->api('repo')->find('chess', array('language' => 'php', 'starting_page' => 2));
```

### Get extended information about a repository

```php
<?php

$repo = $client->api('repo')->show('KnpLabs', 'php-github-api')
```

Returns an array of information about the specified repository.

### Get the repositories of a specific user

```php
<?php

$repos = $client->api('user')->repositories('KnpLabs');
```

Returns a list of repositories.

### Create a repository

```php
<?php

$client->authenticate();
$repo = $client->api('repo')->create('my-new-repo', 'This is the description of a repo', 'http://my-repo-homepage.org', true);
```

Creates and returns a public repository named my-new-repo.

### Update a repository

```php
<?php

$client->authenticate();
$repo = $client->api('repo')->update('username', 'my-new-repo', array('description' => 'some new description'));
```

The value array also accepts the parameters
* `description`
* `homepage`
* `has_wiki`
* `has_issues`
* `has_downloads`

Updates and returns the repository named 'my-new-repo' that is owned by 'username'.

### Delete a repository

```php
<?php

$client->authenticate();
$client->api('repo')->delete('username', 'my-new-repo'); // Get the deletion token
```

Deletes the my-new-repo repository.

### Making a repository public or private

```php
<?php

$client->authenticate();
// Make repo public
$client->api('repo')->update('username', 'reponame', array('private' => false));
// Make repo private
$client->api('repo')->update('username', 'reponame', array('private' => true));
```

Makes the 'reponame' repository public or private and returns the repository.

### Get the deploy keys of a repository

```php
<?php

$keys = $client->api('repo')->keys()->all('username', 'reponame');
```

Returns a list of the deploy keys for the 'reponame' repository.

### Add a deploy key to a repository

```php
<?php

$client->authenticate();
$key = $client->api('repo')->keys()->create('username', 'reponame', array('title' => 'key title', 'key' => 12345));
```

Adds a key with title 'key title' to the 'reponame' repository and returns a list of the deploy keys for the repository.

### Remove a deploy key from a repository

```php
<?php

$client->authenticate();
$client->api('repo')->keys()->remove('username', 'reponame', 12345);
```

Removes the key with id 12345 from the 'reponame' repository and returns a list of the deploy keys for the repository.

### Get the collaborators for a repository

```php
<?php

$collaborators = $client->api('repo')->collaborators()->all('username', 'reponame');
```

Returns a list of the collaborators for the 'reponame' repository.

### Add a collaborator to a repository

```php
<?php

$client->api('repo')->collaborators()->add('username', 'reponame', 'KnpLabs');
```

Adds the 'username' user as collaborator to the 'reponame' repository.

### Remove a collaborator from a repository

```php
<?php

$client->api('repo')->collaborators()->remove('username', 'reponame', 'KnpLabs');
```

Remove the 'username' collaborator from the 'reponame' repository.

### Watch and unwatch a repository

```php
<?php

$client->authenticate();
$client->api('current_user')->watchers()->watch('ornicar', 'php-github-api');
$client->api('current_user')->watchers()->unwatch('ornicar', 'php-github-api');
```

Watches or unwatches the 'php-github-api' repository owned by 'ornicar' and returns the repository.

### Fork a repository

```php
<?php

$client->authenticate();
$repository = $client->api('repo')->forks()->create('ornicar', 'php-github-api');
```

Creates a fork of the 'php-github-api' owned by 'ornicar' and returns the newly created repository.

### Get the tags of a repository

```php
<?php

$tags = $client->api('repo')->tags('ornicar', 'php-github-api');
```

Returns a list of tags.

### Get the branches of a repository

```php
<?php

$branches = $client->api('repo')->branches('ornicar', 'php-github-api');
```

Returns a list of branches.

### Get single branch of a repository

```php
<?php

$branch = $client->api('repo')->branches('ornicar', 'php-github-api', 'master');
```

Returns a branch data.

### Get the watchers of a repository

```php
<?php

$watchers = $client->api('repo')->watchers('ornicar', 'php-github-api');
```

Returns list of the users watching the 'php-github-api' owned by 'ornicar'.

### Get the network (forks) of a repository

```php
<?php

$network = $client->api('repo')->forks()->all('ornicar', 'php-github-api');
```

Returns list of the forks of the 'php-github-api' owned by 'ornicar', including the original repository.

### Get the languages for a repository

```php
<?php

$contributors = $client->api('repo')->languages('ornicar', 'php-github-api');
```

Returns a list of languages.

### Get the contributors of a repository

```php
<?php

$contributors = $client->api('repo')->contributors('ornicar', 'php-github-api');
```

Returns a list of contributors.

To include non GitHub users, add a third parameter to true:

```php
<?php

$contributors = $client->api('repo')->contributors('ornicar', 'php-github-api', true);
```
