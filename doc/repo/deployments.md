## Repo / Deployments API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../index.md)

Provides information about deployments for a repository. Wraps [GitHub Deployments API](https://developer.github.com/v3/repos/deployments/).

#### List all deployments.

```php
$deployments = $client->api('deployment')->all('KnpLabs', 'php-github-api');
```

You can also filter the returned results (see [the documentation](https://developer.github.com/v3/repos/deployments/#list-deployments) for more information):

```php
$deployments = $client->api('deployment')->all('KnpLabs', 'php-github-api', array('environment' => 'production'));
```

### List one deployment.

```php
$deployment = $client->api('deployment')->show('KnpLabs', 'php-github-api', $id);
```

#### Create a new deployments.

The `ref` parameter is required.

```php
$data = $client->api('deployment')->create('KnpLabs', 'php-github-api', array('ref' => 'fd6a5f9e5a430dddae8d6a8ea378f913d3a766f9'));
```

Please note that once a deployment is created it cannot be edited. Only status updates can be created.

#### Create a new status update.

The `state` parameter is required. At the time of writing, this must be pending, success, error, or failure.

```php
$data = $client->api('deployment')->updateStatus('KnpLabs', 'php-github-api', 1, array('state' => 'error', 'description' => 'syntax error'));
```

#### Get all status updates for a deployment.

```php
$statusUpdates = $client->api('deployment')->getStatuses('KnpLabs', 'php-github-api', 1);
```
