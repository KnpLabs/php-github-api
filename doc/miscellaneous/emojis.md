## Emojis API
[Back to the navigation](../README.md)

Wraps [GitHub Emojis API](https://docs.github.com/rest/emojis/emojis).

### Lists all available emojis on GitHub.

```php
$emojis = $client->api('emojis')->all();
```
