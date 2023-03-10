## Deployment / Branch policies API
[Back to the "Deployment API"](../deployments.md) | [Back to the navigation](../index.md)

Provides information about deployment branch policies. Wraps [GitHub Deployment branch policies API](https://docs.github.com/en/rest/deployments/branch-policies?apiVersion=2022-11-28#about-deployment-branch-policies).

#### List deployment branch policies.

```php
$policies = $client->deployment()->policies()->all('KnpLabs', 'php-github-api', 'production');
```

### Get one environment.

```php
$policy = $client->deployment()->policies()->show('KnpLabs', 'php-github-api', 'production', $branchPolicyId);
```

#### Create policy.

```php
$data = $client->deployment()->policies()->create('KnpLabs', 'php-github-api', 'production', [
    'name' => 'name'
]);
```

#### Update policy.

```php
$data = $client->deployment()->policies()->update('KnpLabs', 'php-github-api', 'production', $branchPolicyId, [
    'name' => 'name'
]);
```

#### Delete a existing policy.

```php
$policy = $client->deployment()->policies()->remove('KnpLabs', 'php-github-api', 'production', $branchPolicyId);
```
