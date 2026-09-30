## Current user / Memberships API
[Back to the navigation](../README.md)

Wraps [GitHub Organization Memberships API](https://docs.github.com/rest/orgs/members).

### List your memberships

> Requires [authentication](../security.md).

```php
$memberships = $client->currentUser()->memberships()->all();
```

Returns an array of your memberships in all organizations you are part of.

### Show an organization membership

> Requires [authentication](../security.md).

```php
$membership = $client->currentUser()->memberships()->organization('KnpLabs');
```
* `KnpLabs` : the organization

Returns an array of one membership in a specific organization.

### Update an organization membership

> Requires [authentication](../security.md).

```php
$membership = $client->currentUser()->memberships()->edit('KnpLabs');
```
* `KnpLabs` : the organization

Update your membership to an organization. The only possible action is to activate your membership.
