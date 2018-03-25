## Repositories API
[Back to the navigation](README.md)

Searching repositories, getting repository information and managing repository information for authenticated users.
Wrap [GitHub Repo API](http://developer.github.com/v3/repos/). All methods are described on that page.

### List all repositories

#### Simple call

```php
$repos = $client->api('repo')->all();
```

#### Start from a specific repository id

```php
$repos = $client->api('repo')->all(1337);
```

### Search repos by keyword

#### Simple search

```php
$repos = $client->api('repo')->find('symfony');
```

Returns a list of repositories.
#### Advanced search

You can filter the results by language. It takes the same values as the language drop down on [http://github.com/search](http://github.com/search).

```php
$repos = $client->api('repo')->find('chess', array('language' => 'php'));
```

You can specify the page number:

```php
$repos = $client->api('repo')->find('chess', array('language' => 'php', 'start_page' => 2));
```

### Get extended information about a repository

Using the username of the repository owner and the repository name:

```php
$repo = $client->api('repo')->show('KnpLabs', 'php-github-api')
```

Or by using the repository id (note that this is at time of writing an undocumented feature, see [here](https://github.com/piotrmurach/github/issues/283) and [here](https://github.com/piotrmurach/github/issues/282)):

```php
$repo = $client->api('repo')->showById(123456)
```

Returns an array of information about the specified repository.

### Get the repositories of a specific user

```php
$repos = $client->api('user')->repositories('KnpLabs');
```

Returns a list of repositories.

### Create a repository

> Requires [authentication](security.md).

```php
$repo = $client->api('repo')->create('my-new-repo', 'This is the description of a repo', 'http://my-repo-homepage.org', true);
```

Creates and returns a public repository named my-new-repo.

### Update a repository

> Requires [authentication](security.md).

```php
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

> Requires [authentication](security.md).

```php
$client->api('repo')->remove('username', 'my-new-repo'); // Get the deletion token
```

Deletes the my-new-repo repository.

### Making a repository public or private

> Requires [authentication](security.md).

```php
// Make repo public
$client->api('repo')->update('username', 'reponame', array('private' => false));
// Make repo private
$client->api('repo')->update('username', 'reponame', array('private' => true));
```

Makes the 'reponame' repository public or private and returns the repository.

### Get the deploy keys of a repository

```php
$keys = $client->api('repo')->keys()->all('username', 'reponame');
```

Returns a list of the deploy keys for the 'reponame' repository.

### Add a deploy key to a repository

> Requires [authentication](security.md).

```php
$key = $client->api('repo')->keys()->create('username', 'reponame', array('title' => 'key title', 'key' => 12345));
```

Adds a key with title 'key title' to the 'reponame' repository and returns a list of the deploy keys for the repository.

### Remove a deploy key from a repository

> Requires [authentication](security.md).

```php
$client->api('repo')->keys()->remove('username', 'reponame', 12345);
```

Removes the key with id 12345 from the 'reponame' repository and returns a list of the deploy keys for the repository.

### Add a hook to a repository

> Requires [authentication](security.md).

```php
$client->api('repo')->hooks()->create('username', 'reponame', $params);
```

### Remove a hook from a repository

> Requires [authentication](security.md).

```php
$client->api('repo')->hooks()->remove('username', 'reponame', $id);
```

### Return a list of all hooks for the 'reponame' repository

> Requires [authentication](security.md).

```php
$client->api('repo')->hooks()->all('username', 'reponame');
```

### Get the collaborators for a repository

```php
$collaborators = $client->api('repo')->collaborators()->all('username', 'reponame');
```

Returns a list of the collaborators for the 'reponame' repository.

### Add a collaborator to a repository

```php
$client->api('repo')->collaborators()->add('username', 'reponame', 'collaborator');
```

Adds the 'collaborator' user as collaborator to the 'reponame' repository.

### Remove a collaborator from a repository

> Requires [authentication](security.md).

```php
$client->api('repo')->collaborators()->remove('username', 'reponame', 'collaborator');
```

Remove the 'collaborator' collaborator from the 'reponame' repository.

### Get the permissions of a collaborator for a repository

```php
$permissions = $client->api('repo')->collaborators()->permission('username', 'reponame', 'collaborator');
```

Returns the permissions of 'collaborator' collaborator for the 'reponame' repository.


### Watch and unwatch a repository

> Requires [authentication](security.md).

```php
$client->api('current_user')->watchers()->watch('ornicar', 'php-github-api');
$client->api('current_user')->watchers()->unwatch('ornicar', 'php-github-api');
```

Watches or unwatches the 'php-github-api' repository owned by 'ornicar' and returns the repository.

### Fork a repository

> Requires [authentication](security.md).

```php
$repository = $client->api('repo')->forks()->create('ornicar', 'php-github-api');
```

Creates a fork of the 'php-github-api' owned by 'ornicar' and returns the newly created repository.

### Get the tags of a repository

```php
$tags = $client->api('repo')->tags('ornicar', 'php-github-api');
```

Returns a list of tags.

### Get the branches of a repository

```php
$branches = $client->api('repo')->branches('ornicar', 'php-github-api');
```

Returns a list of branches.

### Get single branch of a repository

```php
$branch = $client->api('repo')->branches('ornicar', 'php-github-api', 'master');
```

Returns a branch data.

### Get the watchers of a repository

```php
$watchers = $client->api('repo')->watchers('ornicar', 'php-github-api');
```

Returns list of the users watching the 'php-github-api' owned by 'ornicar'.

### Get the network (forks) of a repository

```php
$network = $client->api('repo')->forks()->all('ornicar', 'php-github-api');
```

Returns list of the forks of the 'php-github-api' owned by 'ornicar', including the original repository.

### Get the languages for a repository

```php
$languages = $client->api('repo')->languages('ornicar', 'php-github-api');
```

Returns a list of languages.

### Get the contributors of a repository

```php
$contributors = $client->api('repo')->contributors('ornicar', 'php-github-api');
```

Returns a list of contributors.

To include non GitHub users, add a third parameter to true:

```php
$contributors = $client->api('repo')->contributors('ornicar', 'php-github-api', true);
```

### Get the commit activity of a repository

```php
$activity = $client->api('repo')->activity('ornicar', 'php-github-api');
```

Returns an array of commit activity group by week.

### `Moved` repositories
Github repositories can be moved to another org/user, but it remains the `id`.
In case if you can't no more find repo, you can retrieve it by `id`:

```php
use Github\HttpClient\Message\ResponseMediator;

$data = $client->getHttpClient()->get('/repositories/24560307');
$repo = ResponseMediator::getContent($data);
```

### Get the milestones of a repository

```php
$milestones = $client->api('repo')->milestones('ornicar', 'php-github-api');
```

Returns a list of milestones.

### Get the contents of a repository's code of conduct

```php
$codeOfConduct = $client->api('repo')->codeOfConduct('ornicar', 'php-github-api');
```

### List all topics for a repository

```php
$topics = $client->api('repo')->topics('ornicar', 'php-github-api');
```

### Replace all topics for a repository

```php
$currentTopics = $client->api('repo')->replaceTopics('ornicar', 'php-github-api', ['new', 'topics']);
```

### Transfer a repo to another user

```php
$repo = $client->api('repo')->transfer('KnpLabs', 'php-github-api', 'github');
```
You can optionally assign some teams by passing an array with their ID's if you're transferring the repo to an organization:

```php
$repo = $client->api('repo')->transfer('KnpLabs', 'php-github-api', 'github', [1234]);
```
