## Repo / Workflow Runs API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

### List workflow runs for a repository

https://docs.github.com/en/rest/reference/actions#list-workflow-runs-for-a-repository

```php
$workflowRuns = $client->api('repo')->workflowRuns()->all('KnpLabs', 'php-github-api');
```

### List workflow runs

https://docs.github.com/en/rest/reference/actions#list-workflow-runs

```php
$runs = $client->api('repo')->workflowRuns()->listRuns('KnpLabs', 'php-github-api', $workflow);
```

### Get a workflow run

https://docs.github.com/en/rest/reference/actions#get-a-workflow-run

```php
$workflowRun = $client->api('repo')->workflowRuns()->show('KnpLabs', 'php-github-api', $runId);
```

### Delete a workflow run

https://docs.github.com/en/rest/reference/actions#delete-a-workflow-run

```php
$client->api('repo')->workflowRuns()->remove('KnpLabs', 'php-github-api', $runId);
```

### Re-run a workflow

https://docs.github.com/en/rest/reference/actions#re-run-a-workflow

```php
$client->api('repo')->workflowRuns()->rerun('KnpLabs', 'php-github-api', $runId);
```

### Cancel a workflow run

https://docs.github.com/en/rest/reference/actions#cancel-a-workflow-run

```php
$client->api('repo')->workflowRuns()->cancel('KnpLabs', 'php-github-api', $runId);
```

### Get workflow run usage

https://docs.github.com/en/rest/reference/actions#get-workflow-run-usage

```php
$workflowUsage = $client->api('repo')->workflowRuns()->usage('KnpLabs', 'php-github-api', $runId);
```

### Download workflow run logs

https://docs.github.com/en/rest/reference/actions#download-workflow-run-logs

```php
$logs = $client->api('repo')->workflowRuns()->downloadLogs('KnpLabs', 'php-github-api', $runId);

file_put_contents('logs.zip', $logs);
```

### Delete workflow run logs

https://docs.github.com/en/rest/reference/actions#delete-workflow-run-logs

```php
$client->api('repo')->workflowRuns()->deleteLogs('KnpLabs', 'php-github-api', $runId);
```
