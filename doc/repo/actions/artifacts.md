## Repo / Actions / Artifacts API
[Back to the "Repos API"](../../repos.md) | [Back to the navigation](../../README.md)

### List artifacts for a repository

https://docs.github.com/rest/actions/artifacts#list-artifacts-for-a-repository

```php
$artifacts = $client->api('repo')->artifacts()->all('KnpLabs');
```

### List workflow run artifacts

https://docs.github.com/rest/actions/artifacts#list-workflow-run-artifacts

```php
$runArtifacts = $client->api('repo')->artifacts()->runArtifacts('KnpLabs', 'php-github-api', $runId);
```

### Get an artifact

https://docs.github.com/rest/actions/artifacts#get-an-artifact

```php
$artifact = $client->api('repo')->artifacts()->show('KnpLabs', 'php-github-api', $artifactId);
```

### Delete an artifact

https://docs.github.com/rest/actions/artifacts#delete-an-artifact

```php
$client->api('repo')->artifacts()->delete('KnpLabs', 'php-github-api', $artifactId);
```


### Download an artifact

https://docs.github.com/rest/actions/artifacts#download-an-artifact

```php
$artifactFile = $client->api('repo')->artifacts()->download('KnpLabs', 'php-github-api', $artifactId, $format = 'zip');
file_put_contents($artifactId.'.'.$format, $artifactFile);
```
