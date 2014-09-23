## Repo / Contents API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../index.md)

### Get a repository's README

```php
$readme = $client->api('repo')->contents()->readme('knp-labs', 'php-github-api', $reference);
```

### Get information about a repository file or directory

```php
$fileInfo = $client->api('repo')->contents()->show('knp-labs', 'php-github-api', $path, $reference);
```

### Check that a file or directory exists in the repository
```php
$fileExists = $client->api('repo')->contents()->exists('knp-labs', 'php-github-api', $path, $reference);
```

### Create a file
```php
$committer = array('name' => 'KnpLabs', 'email' => 'info@knplabs.com');

$fileInfo = $client->api('repo')->contents()->create('knp-labs', 'php-github-api', $path, $content, $commitMessage, $branch, $committer);
```

### Update a file

```php
$committer = array('name' => 'KnpLabs', 'email' => 'info@knplabs.com');
$oldFile = $client->api('repo')->contents()->show('knp-labs', 'php-github-api', $path, $branch);

$fileInfo = $client->api('repo')->contents()->create('knp-labs', 'php-github-api', $path, $content, $commitMessage, $oldFile['sha'], $branch, $committer);
```

### Remove a file

```php
$committer = array('name' => 'KnpLabs', 'email' => 'info@knplabs.com');
$oldFile = $client->api('repo')->contents()->show('knp-labs', 'php-github-api', $path, $branch);

$fileInfo = $client->api('repo')->contents()->rm('knp-labs', 'php-github-api', $path, $commitMessage, $oldFile['sha'], $branch, $committer);
```

### Get repository archive

```php
// @todo Document
```

### Download a file

```php
$fileContent = $client->api('repo')->contents()->download('knp-labs', 'php-github-api', $path, $reference);
```
