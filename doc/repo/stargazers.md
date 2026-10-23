## Repo / Stargazers API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

Provides information about the users who have starred a repository. Wraps [GitHub Starring API](https://docs.github.com/rest/activity/starring#list-stargazers).

### List all stargazers

```php
$stargazers = $client->api('repo')->stargazers();

$stargazers->all('twbs', 'bootstrap');
```
