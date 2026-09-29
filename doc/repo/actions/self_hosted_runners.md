## Repo / Actions / Self Hosted Runners API
[Back to the "Repos API"](../../repos.md) | [Back to the navigation](../../README.md)

# List self-hosted runners for a repository

https://docs.github.com/rest/actions/self-hosted-runners#list-self-hosted-runners-for-a-repository

```php
$runners = $client->api('repo')->selfHostedRunners()->all('KnpLabs', 'php-github-api');
```

# Get a self-hosted runner for a repository

https://docs.github.com/rest/actions/self-hosted-runners#get-a-self-hosted-runner-for-a-repository

```php
$runner = $client->api('repo')->selfHostedRunners()->show('KnpLabs', 'php-github-api', $runnerId);
```

# Delete a self-hosted runner from a repository

https://docs.github.com/rest/actions/self-hosted-runners#delete-a-self-hosted-runner-from-a-repository

```php
$client->api('repo')->selfHostedRunners()->remove('KnpLabs', 'php-github-api', $runnerId);
```

# List runner applications for a repository

https://docs.github.com/rest/actions/self-hosted-runners#list-runner-applications-for-a-repository

```php
$applications = $client->api('repo')->selfHostedRunners()->applications('KnpLabs', 'php-github-api');
```

