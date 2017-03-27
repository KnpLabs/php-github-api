## Gitignore API
[Back to the navigation](../README.md)

### Lists all available gitignore templates

```php
$gitignoreTemplates = $client->api('gitignore')->all();
```

### Get a single template

```php
$gitignore = $client->api('gitignore')->show('C');
```
