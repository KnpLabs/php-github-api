## Repo / Checks runs API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

### Create a check run

[Visit GitHub for a full of list of parameters and their descriptions.](https://docs.github.com/en/rest/reference/checks#create-a-check-run)

```php
$params = [
  'name' => 'my check', # required
  'head_sha' => $commitSha, # required
  'status' => 'queued',
  'output' => [/*...*/]
];
$check = $client->api('repo')->checkRuns()->create('KnpLabs', 'php-github-api', $params);
```

### Get a check run

https://docs.github.com/en/rest/reference/checks#get-a-check-run

```php
$check = $client->api('repo')->checkRuns()->show('KnpLabs', 'php-github-api', $checkRunId);
```

### Update an existing check run

https://docs.github.com/en/rest/reference/checks#update-a-check-run

```php
$params = [
  'name' => 'my check',
  'status' => 'in_progress',
  'output' => [/*...*/]
];
$check = $client->api('repo')->checkRuns()->update('KnpLabs', 'php-github-api', $checkRunId, $params);
```

### List check run annotations

https://docs.github.com/en/rest/reference/checks#list-check-run-annotations

```php
$annotations = $client->api('repo')->checkRuns()->annotations('KnpLabs', 'php-github-api', $checkRunId);
```

### List check runs for a check suite

https://docs.github.com/en/rest/reference/checks#list-check-runs-in-a-check-suite

```php
$params = [/*...*/];
$checks = $client->api('repo')->checkRuns()->allForCheckSuite('KnpLabs', 'php-github-api', $checkSuiteId, $params);
```

### List check runs for a Git reference

https://docs.github.com/en/rest/reference/checks#list-check-runs-for-a-git-reference

```php
$params = [/*...*/];
$checks = $client->api('repo')->checkRuns()->allForReference('KnpLabs', 'php-github-api', $reference, $params);
```

### Rerequest a check run

https://docs.github.com/en/rest/reference/checks#rerequest-a-check-run

```php
$checks = $client->api('repo')->checkRuns()->rerequest('KnpLabs', 'php-github-api', $checkRunId);
```
