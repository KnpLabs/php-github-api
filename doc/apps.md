## Applications API
[Back to the navigation](README.md)

Wraps [GitHub Applications API](http://developer.github.com/v3/apps/).

### Create a new installation token
For the installation id 123 use the following:
```php
$token = $client->api('apps')->createInstallationToken(123);
```

To create an access token on behalf of a user with id 456 use:
```php
$token = $client->api('apps')->createInstallationToken(123, 456);
```

### Find all installations

Find all installations for the authenticated application.
```php
$installations = $client->api('apps')->findInstallations();
```

### Find installations for a user

```php
$installations = $client->api('current_user')->installations();
```

### List repositories

List repositories that are accessible to the authenticated installation.
```php
$repositories = $client->api('apps')->listRepositories($userId);
```

### List repositories for a given installation and user

```php
$repositories = $client->api('current_user')->repositoriesByInstallation($installationId, $parameters);
```

### Add repository to installation
```php
$client->api('apps')->addRepository($installationId, $repositoryId);
```

### Remove repository from installation
```php
$client->api('apps')->removeRepository($installationId, $repositoryId);
```

### Get authenticated app

```php
$authenticatedApp = $client->api('apps')->getAuthenticatedApp();
```
