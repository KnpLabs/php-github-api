## Gitignore API
[Back to the navigation](../README.md)

Wraps [GitHub Gitignore API](https://docs.github.com/rest/gitignore/gitignore).

### Lists all available gitignore templates

```php
$gitignoreTemplates = $client->api('gitignore')->all();
```

### Get a single template

```php
$gitignore = $client->api('gitignore')->show('C');
```
