## GraphQL API
[Back to the navigation](README.md)

Wraps [GitHub v4 API (GraphQL API)](http://developer.github.com/v4/).

#### Execute a query

```php
$rateLimits = $client->api('graphql')->execute($query);
```
