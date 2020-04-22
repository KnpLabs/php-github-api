## Repo / Checks API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

### Create a check for a commit

[Visit GitHub for a full of list of parameters and their descriptions.](https://developer.github.com/v3/checks/runs/#create-a-check-run)

```php
$params = [
  'name' => 'my check', # required
  'head_sha' => $commitSha, # required
  'status' => 'pending',
  'details_url' => 'https://nimbleci.com/...',
  'output' => {...}
];
$check = $client->api('repo')->checks()->create('NimbleCI', 'docker-web-tester-behat', $params);
```

### Update an existing check on a commit

https://developer.github.com/v3/checks/runs/#update-a-check-run

```php
$params = [
  'name' => 'my check',
  'status' => 'pending',
  'details_url' => 'https://nimbleci.com/...',
  'output' => {...}
];
$check = $client->api('repo')->checks()->create('NimbleCI', 'docker-web-tester-behat', $checkRunId, $params);
```

### List check runs for a Git reference

https://developer.github.com/v3/checks/runs/#list-check-runs-for-a-git-reference

```php
$params = [
  'check_name' => 'my check',
  'status' => 'completed',
  'filter' => 'latest',
];
$checks = $client->api('repo')->checks()->all('NimbleCI', 'docker-web-tester-behat', $ref, $params);
```

### Get a check run

https://developer.github.com/v3/checks/runs/#get-a-check-run

```php
$check = $client->api('repo')->checks()->show('NimbleCI', 'docker-web-tester-behat', $checkRunId);
```

### List check run annotations

https://developer.github.com/v3/checks/runs/#list-check-run-annotations

```php
$annotations = $client->api('repo')->checks()->annotations('NimbleCI', 'docker-web-tester-behat', $checkRunId);
```
