## Instegrations API
[Back to the navigation](README.md)

Wraps [GitHub Integrations API](http://developer.github.com/v3/integrations/).

### Create a new installation token
For the installation id 123 use the following:
```php
$token = $client->api('integrations')->createInstallationToken(123);
```

To create an access token on behalf of a user with id 456 use:
```php
$token = $client->api('integrations')->createInstallationToken(123, 456);
```

### Find all installations

Find all installations for the authenticated integration.
```php
$installations = $client->api('integrations')->findInstallations();
```

### Find installations for a user

```php
$installations = $client->api('current_user')->installations();
```

### List repositories

List repositories that are accessible to the authenticated installation.
```php
$repositories = $client->api('integrations')->listRepositories(456);
```

### List repositories for a given installation and user

```
$repositories = $client->api('current_user')->repositoriesByInstallation(456);
```

### Add repository to installation
Add a single repository to an installation.
```php
$client->api('integrations')->addRepository(123);
```

### Remove repository from installation
Remove a single repository from an installation.
```php
$client->api('integrations')->removeRepository(123);
```
