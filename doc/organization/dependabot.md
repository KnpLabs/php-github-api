## Organization / Dependabot API

[Back to the "Organization API"](../../organization.md) | [Back to the navigation](../../README.md)

# List Dependabot alerts for an Organization

https://docs.github.com/en/rest/dependabot/alerts?apiVersion=2022-11-28#list-dependabot-alerts-for-an-organization

```php
$alerts = $client->api('organization')->dependabot()->alerts('KnpLabs', ['severity' => 'critical']);
```
