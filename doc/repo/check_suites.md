## Repo / Check suites API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

### Create a check suite

https://docs.github.com/en/free-pro-team@latest/rest/reference/checks#create-a-check-suite

```php
$params = [
  'head_sha' => $commitSha, # required
];
$check = $client->api('repo')->checkSuites()->create('KnpLabs', 'php-github-api', $params);
```

### Update check suite preferences

https://docs.github.com/en/free-pro-team@latest/rest/reference/checks#update-repository-preferences-for-check-suites

```php
$params = [/*...*/];
$check = $client->api('repo')->checkSuites()->updatePreferences('KnpLabs', 'php-github-api', $params);
```

### Get a check suite

https://docs.github.com/en/free-pro-team@latest/rest/reference/checks#get-a-check-suite

```php
$check = $client->api('repo')->checkSuites()->getCheckSuite('KnpLabs', 'php-github-api', $checkSuiteId);
```

### Rerequest a check suite

https://docs.github.com/en/free-pro-team@latest/rest/reference/checks#rerequest-a-check-suite

```php
$annotations = $client->api('repo')->checkSuites()->rerequest('KnpLabs', 'php-github-api', $checkSuiteId);
```


### List check suites for a Git reference

https://docs.github.com/en/free-pro-team@latest/rest/reference/checks#list-check-suites-for-a-git-reference

```php
$params = [/*...*/];
$checks = $client->api('repo')->checkSuites()->allForReference('KnpLabs', 'php-github-api', $reference, $params);
```
