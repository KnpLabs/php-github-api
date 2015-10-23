## Organization API
[Back to the navigation](README.md)

Wraps [GitHub Organization API](http://developer.github.com/v3/orgs/).

Additional APIs:
* [Members API](organization/members.md)
* [Teams API](organization/teams.md)

### List issues in an organization
[GitHub Issues API](https://developer.github.com/v3/issues/).

```php
$issues = $client->api('organizations')->issues('KnpLabs', 'php-github-api', array('state' => 'open'));
```
You can specify the page number:

```php
$issues = $client->api('organizations')->issues('KnpLabs', 'php-github-api', array('state' => 'open'), 2);
```

Returns an array of issues.



To be written...
