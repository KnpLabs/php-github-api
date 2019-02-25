## Rate Limit API
[Back to the navigation](README.md)

Get rate limit wrappers from [GitHub Rate Limit API](http://developer.github.com/v3/rate_limit/).

#### Get All Rate Limits

```php
/** @var \Github\Api\RateLimit\RateLimitResource[] $rateLimits */
$rateLimits = $client->api('rate_limit')->getLimits();
```

#### Get Core Rate Limit

```php
$coreLimit = $client->api('rate_limit')->getResource('core')->getLimit();
$remaining = $client->api('rate_limit')->getResource('core')->getRemaining();
$reset = $client->api('rate_limit')->getResource('core')->getReset();
```

#### Get Search Rate Limit

```php
$searchLimit = $client->api('rate_limit')->getResource('search')->getLimit();
```

#### Get GraphQL Rate Limit

```php
$searchLimit = $client->api('rate_limit')->getResource('graphql')->getLimit();
```
