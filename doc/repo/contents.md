## Repo / Contents API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

---

You can read about references [here](https://developer.github.com/v3/git/refs/).


### Get a repository's README

```php
$readme = $client->api('repo')->contents()->readme('KnpLabs', 'php-github-api', $reference);
```

### Get information about a repository file or directory

```php
$fileInfo = $client->api('repo')->contents()->show('KnpLabs', 'php-github-api', $path, $reference);
```

### Check that a file or directory exists in the repository
```php
$fileExists = $client->api('repo')->contents()->exists('KnpLabs', 'php-github-api', $path, $reference);
```

### Create a file
```php
$committer = array('name' => 'KnpLabs', 'email' => 'info@knplabs.com');

$fileInfo = $client->api('repo')->contents()->create('KnpLabs', 'php-github-api', $path, $content, $commitMessage, $branch, $committer);
```

### Update a file

```php
$committer = array('name' => 'KnpLabs', 'email' => 'info@knplabs.com');
$oldFile = $client->api('repo')->contents()->show('KnpLabs', 'php-github-api', $path, $branch);

$fileInfo = $client->api('repo')->contents()->update('KnpLabs', 'php-github-api', $path, $content, $commitMessage, $oldFile['sha'], $branch, $committer);
```

### Remove a file

```php
$committer = array('name' => 'KnpLabs', 'email' => 'info@knplabs.com');
$oldFile = $client->api('repo')->contents()->show('KnpLabs', 'php-github-api', $path, $branch);

$fileInfo = $client->api('repo')->contents()->rm('KnpLabs', 'php-github-api', $path, $commitMessage, $oldFile['sha'], $branch, $committer);
```

### Get repository archive

```php
$archive = $client->api('repo')->contents()->archive('KnpLabs', 'php-github-api', $format, $reference);
```

### Download a file

```php
$fileContent = $client->api('repo')->contents()->download('KnpLabs', 'php-github-api', $path, $reference);
```
