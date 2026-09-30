## Licenses API
[Back to the navigation](../README.md)

Wraps [GitHub Licenses API](https://docs.github.com/rest/licenses/licenses).

### Lists all licenses.

```php
$licenses = $client->api('licenses')->all();
```

### Get a license.

```php
$license = $client->api('licenses')->show('gpl-2.0');
```
