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
