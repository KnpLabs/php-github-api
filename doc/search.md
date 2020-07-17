## Search API
[Back to the navigation](README.md)

Searching repositories, code, issues and users.
Wrap [GitHub Search API](http://developer.github.com/v3/search/). All methods are described on that page.

### Search repositories

```php
$repos = $client->api('search')->repositories('github language:php');
```

Returns a list of repositories found by such criteria.

### Search code
 
```php
$files = $client->api('search')->code('@todo language:php');
```

Returns a list of files found by such criteria (containing "@todo" and language==php).

### Search issues

```php
$issues = $client->api('search')->issues('bug language:php');
```

Returns a list of issues found by such criteria.

### Search users

```php
$users = $client->api('search')->users('location:Amsterdam language:php');
```

### Search commits

```php
$commits = $client->api('search')->commits('repo:octocat/Spoon-Knife+css');
```

Returns a list of users found by such criteria.

### Sorting results

You can sort results using 2-3 arguments.

```php
$repos = $client->api('search')->repositories('...', 'created', 'asc');
$files = $client->api('search')->code('...........', 'indexed', 'desc');
$issues = $client->api('search')->issues('.........', 'comments', 'asc');
$users = $client->api('search')->users('..........', 'followers', 'asc');
$commits = $client->api('search')->commits('..........', 'author-date', 'desc');
```
