## Current user / Repo API
[Back to the navigation](../README.md)

> Requires [authentication](../security.md).

### List all public and private repositories

```php
$emails = $client->currentUser()->repositories();
```
