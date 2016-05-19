## Repo / Statuses API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

### List all statuses for a commit

```php
$statuses = $client->api('repo')->statuses()->show('NimbleCI', 'docker-web-tester-behat', $commitSha);
```

### Get the combined statuses for a commit

```php
$statuses = $client->api('repo')->statuses()->combined('NimbleCI', 'docker-web-tester-behat', $commitSha);
```

### Create a status for a commit

For the full list of parameters see https://developer.github.com/v3/repos/statuses/#parameters

```php
$params = [
  'state' => 'pending',  # The 'state' element is required
  'target_url' => 'https://nimbleci.com/...',
  'description' => 'A great description...',
  'context' => 'my-context',
];
$statuses = $client->api('repo')->statuses()->create('NimbleCI', 'docker-web-tester-behat', $commitSha, $params);
```
