## Repo / Environments API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../index.md)

Provides information about environments for a repository. Wraps [GitHub Environments API](https://docs.github.com/en/rest/deployments/environments?apiVersion=2022-11-28).

Additional APIs:
* [Secrets API](environment/secrets.md)
* [Variables API](environment/variables.md)

#### List all environments.

```php
$environments = $client->api('environment')->all('KnpLabs', 'php-github-api');
```

### Get one environment.

```php
$environment = $client->api('environment')->show('KnpLabs', 'php-github-api', $name);
```

#### Create or update environment.

```php
$data = $client->api('environment')->createOrUpdate('KnpLabs', 'php-github-api', $name);
```

#### Delete a existing environment.

```php
$environment = $client->api('environment')->remove('KnpLabs', 'php-github-api', $name);
```
