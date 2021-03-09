## Repo / Workflow Jobs API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

### List jobs for a workflow run

https://docs.github.com/en/rest/reference/actions#list-jobs-for-a-workflow-run

```php
$client->api('repo')->workflowJobs()->all('KnpLabs', 'php-github-api', $runId);
```

### Get a job for a workflow run

https://docs.github.com/en/rest/reference/actions#get-a-job-for-a-workflow-run

```php
$job = $client->api('repo')->workflowJobs()->all('KnpLabs', 'php-github-api', $jobId);
```

### Download job logs for a workflow run

https://docs.github.com/en/rest/reference/actions#download-job-logs-for-a-workflow-run

```php
$jobLogs = $client->api('repo')->workflowJobs()->downloadLogs('KnpLabs', 'php-github-api', $jobId);
file_put_contents('jobLogs.zip', $jobLogs);
```
