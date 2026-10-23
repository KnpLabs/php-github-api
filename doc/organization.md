## Organization API
[Back to the navigation](README.md)

Wraps [GitHub Organization API](https://docs.github.com/rest/orgs/orgs).

Additional APIs:
* [Members API](organization/members.md)
* [Teams API](organization/teams.md)

### List issues in an organization
[GitHub Issues API](https://docs.github.com/rest/issues/issues#list-organization-issues-assigned-to-the-authenticated-user).

```php
$issues = $client->api('organizations')->issues('KnpLabs', 'php-github-api', array('state' => 'open'));
```
You can specify the page number:

```php
$issues = $client->api('organizations')->issues('KnpLabs', 'php-github-api', array('state' => 'open'), 2);
```

Returns an array of issues.



To be written...
