## Pull Requests / Review Requests API
[Back to the "Pull Requests API"](../pull_requests.md) | [Back to the navigation](../README.md)

### List all review requests

```php
$reviewRequests = $client->api('pull_request')->reviewRequests()->all('twbs', 'bootstrap', 12);
```

### Create a review request

```php
$client->api('pull_request')->reviewRequests()->create('twbs', 'bootstrap', 12, array('user1', 'user2'));
```

### Remove a review request

```php
$client->api('pull_request')->reviewRequests()->remove('twbs', 'bootstrap', 12, array('user1', 'user2'));
```
