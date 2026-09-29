## Repo / Contents API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

---

Wraps [GitHub Repository Contents API](https://docs.github.com/rest/repos/contents).

You can read about references [here](https://docs.github.com/rest/git/refs).


### Get a repository's README

https://docs.github.com/rest/repos/contents#get-a-repository-readme

```php
$readme = $client->api('repo')->contents()->readme('KnpLabs', 'php-github-api', $reference);
```

### Get information about a repository file or directory

https://docs.github.com/rest/repos/contents#get-repository-content

```php
$fileInfo = $client->api('repo')->contents()->show('KnpLabs', 'php-github-api', $path, $reference);
```

### Check that a file or directory exists in the repository
```php
$fileExists = $client->api('repo')->contents()->exists('KnpLabs', 'php-github-api', $path, $reference);
```

### Create a file

https://docs.github.com/rest/repos/contents#create-or-update-file-contents

```php
$committer = array('name' => 'KnpLabs', 'email' => 'info@knplabs.com');

$fileInfo = $client->api('repo')->contents()->create('KnpLabs', 'php-github-api', $path, $content, $commitMessage, $branch, $committer);
```

### Update a file

https://docs.github.com/rest/repos/contents#create-or-update-file-contents

```php
$committer = array('name' => 'KnpLabs', 'email' => 'info@knplabs.com');
$oldFile = $client->api('repo')->contents()->show('KnpLabs', 'php-github-api', $path, $branch);

$fileInfo = $client->api('repo')->contents()->update('KnpLabs', 'php-github-api', $path, $content, $commitMessage, $oldFile['sha'], $branch, $committer);
```

### Remove a file

https://docs.github.com/rest/repos/contents#delete-a-file

```php
$committer = array('name' => 'KnpLabs', 'email' => 'info@knplabs.com');
$oldFile = $client->api('repo')->contents()->show('KnpLabs', 'php-github-api', $path, $branch);

$fileInfo = $client->api('repo')->contents()->rm('KnpLabs', 'php-github-api', $path, $commitMessage, $oldFile['sha'], $branch, $committer);
```

### Get repository archive

https://docs.github.com/rest/repos/contents#download-a-repository-archive-tar

```php
$archive = $client->api('repo')->contents()->archive('KnpLabs', 'php-github-api', $format, $reference);
```

### Download a file

```php
$fileContent = $client->api('repo')->contents()->download('KnpLabs', 'php-github-api', $path, $reference);
```
