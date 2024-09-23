## Organization / Webhooks API
[Back to the navigation](../README.md)

Listing, showing, assigning, and removing orgniazationroles.
Wraps [GitHub Organization Roles API](https://docs.github.com/en/rest/orgs/organization-roles).

Additional APIs:
* [Organization](../doc/organization)

### List all organizaton roles in an organization

> Requires [authentication](../security.md).

```php
$roles = $client->organization()->organizationRoles()->all('acme');
```

Returns a counter and a list of organization roles in the organization.

### Get an organization role in an organization

> Requires [authentication](../security.md).

```php
$role = $client->organization()->organizationRoles()->show('acme', 123);
```

Returns a single organization role in the organization.

### List all teams with role assigned in an organization

> Requires [authentication](../security.md).

```php
$users = $client->organization()->organizationRoles()->listTeamsWithRole('acme', 1);
```

Returns a list of teams with the role assigned to them.

### Assign a single role to a team in an organization

> Requires [authentication](../security.md).

```php
$client->organization()->organizationRoles()->assignRoleToTeam('acme', 1, 'admin-user');
```

No content is returned.

### Remove a single role from a team in an organization

> Requires [authentication](../security.md).

```php
$client->organization()->organizationRoles()->removeRoleFromTeam('acme', 1, 'admin-team');
```

No content is returned.

### Remove all roles from a team in an organization

> Requires [authentication](../security.md).

```php
$client->organization()->organizationRoles()->removeAllRolesFromTeam('acme', 'admin-team');
```

No content is returned.

### List all users with role assigned in an organization

> Requires [authentication](../security.md).

```php
$users = $client->organization()->organizationRoles()->listUsersWithRole('acme', 1);
```

Returns a list of users with the role assigned to them.

### Assign a single role to a user in an organization

> Requires [authentication](../security.md).

```php
$client->organization()->organizationRoles()->assignRoleToUser('acme', 1, 'admin-user');
```

No content is returned.

### Remove a single role from a user in an organization

> Requires [authentication](../security.md).

```php
$client->organization()->organizationRoles()->removeRoleFromUser('acme', 1, 'admin-user');
```

No content is returned.

### Remove all roles from a user in an organization

> Requires [authentication](../security.md).

```php
$client->organization()->organizationRoles()->removeAllRolesFromUser('acme', 'admin-user');
```

No content is returned.
