## Repo / Tags API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

Provides information about tags for a repository. Wraps [GitHub Repository tags API](https://docs.github.com/rest/repos/repos#list-repository-tags).

### List all tags

```php
$tags = $client->api('repo')->tags('twbs', 'bootstrap');
```
