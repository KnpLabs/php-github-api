## Current user / Repo API
[Back to the navigation](../README.md)

> Requires [authentication](../security.md).

### List repositories that are accessible to the authenticated user.

```php
$repositories = $client->currentUser()->repositories();
```

This includes repositories owned by the authenticated user, repositories where the authenticated user is a collaborator, and repositories that the authenticated user has access to through an organization membership.

There are three values that can be passed into the `repositories` method: `type`, `sort` and `direction`

| Parameters    | Default     | Possible Values                              |
| ------------- |-------------| -------------------------------------------- |
| type          | `owner`     | `all`, `owner`, `public`, `private`, `member`
| sort          | `full_name` | `created`, `updated`, `pushed`, `full_name`
| direction     | `asc`       | `asc`, `desc`

> See https://developer.github.com/v3/repos/#list-your-repositories for possible values and additional information 

#### Code Example:

```php
$client = new \Github\Client(); 
$client->authenticate($github_token, null, \Github\Client::AUTH_HTTP_TOKEN);
$client->currentUser()->repositories();
```
