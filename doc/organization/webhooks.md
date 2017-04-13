## Organization / Webhooks API
[Back to the navigation](README.md)

Listing, showing, creating, updating, testing and removing organizations webhooks.
Wraps [GitHub Organization Webhooks API](https://developer.github.com/v3/orgs/hooks/).

Additional APIs:
* [Organization](issue/organization.md)

### List webhooks for an organization

> Requires [authentication](../security.md).

```php
$webhooks = $client->organization()->all('KnpLabs');
```

Returns an array of webhooks for the organization.

### Get a webhook for an organization

> Requires [authentication](../security.md).

```php
$webhook = $client->organization()->show('KnpLabs', 123);
```

Returns the webhook with the ID 123 as an array for the organization.

### Create a new webhook for an organization

> Requires [authentication](../security.md).

```php
$webhook = $client->organization()->create('KnpLabs', array(
	'name'   => 'web',
	'active' => true,
	'events' => array(
		'push',
		'pull_request'
	),
	'config' => array(
		'url'          => 'http=>//example.com/webhook',
		'content_type' => 'json'
	)
));
```

Creates a new webhook for the organization.
*name* and *url* parameters are required.

The create webhook will be returned as an array.

### Update an existing webhook for an organization

> Requires [authentication](../security.md).

```php
$success = $client->organization()->update('KnpLabs', 123, array(
	'active' => true,
	'events' => array(
		'push',
		'pull_request'
	),
	'config' => array(
		'url'          => 'http=>//example.com/webhook',
		'content_type' => 'json'
	)
));
```

Update an existing webhook with ID 123 for the organization.
*url* parameter is required.

In case of success, an array of information about the webhook will be returned.

### Ping a webhook for an organization

> Requires [authentication](../security.md).

```php
$client->organization()->pings('KnpLabs', 123);
```

No content is returned.

### Delete a webhook for an organization

> Requires [authentication](../security.md).

```php
$client->organization()->delete('KnpLabs', 123);
```

No content is returned.
