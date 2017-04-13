## Rate Limit API
[Back to the navigation](README.md)

Get Rate Limit
Wraps [GitHub Rate Limit API](http://developer.github.com/v3/rate_limit/).

#### Get All Rate Limits.

```php
$rateLimits = $client->api('rate_limit')->getRateLimits();
```

#### Get Core Rate Limit

```php
$coreLimit = $client->api('rate_limit')->getCoreLimit();
```

#### Get Search Rate Limit

```php
$searchLimit = $client->api('rate_limit')->getSearchLimit();
```
