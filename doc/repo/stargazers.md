## Repo / Stargazers API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

### List all stargazers

```php
$stargazers = $client->api('repo')->stargazers();

$stargazers->all('twbs', 'bootstrap');
```
