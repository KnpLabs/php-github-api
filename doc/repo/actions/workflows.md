## Repo / Workflows API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

### List repository workflows

https://docs.github.com/en/rest/reference/actions#list-repository-workflows

```php
$workflows = $client->api('repo')->workflows()->all('KnpLabs', 'php-github-api');
```

### Get a workflow

https://docs.github.com/en/rest/reference/actions#get-a-workflow

```php
$workflow = $client->api('repo')->workflows()->show('KnpLabs', 'php-github-api', $workflow);
```

### Get workflow usage

https://docs.github.com/en/rest/reference/actions#get-workflow-usage

```php
$usage = $client->api('repo')->workflows()->usage('KnpLabs', 'php-github-api', $workflow);
```

### Dispatch a workflow

https://docs.github.com/en/rest/reference/actions#create-a-workflow-dispatch-event

```php
$client->api('repo')->workflows()->dispatches('KnpLabs', 'php-github-api', $workflow, 'main');
```
