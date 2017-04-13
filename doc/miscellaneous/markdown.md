## Markdown API
[Back to the navigation](../README.md)

### Render an arbitrary Markdown document

```php
$gitignoreTemplates = $client->api('markdown')->render('Hello world github/linguist#1 **cool**, and #1!', 'markdown');
```

### Render a Markdown document in raw mode

```php
$gitignore = $client->api('markdown')->renderRaw('path/to/file');
```
