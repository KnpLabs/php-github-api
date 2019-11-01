## Rate Limit API
[Back to the navigation](README.md)

Get rate limit wrappers from [GitHub Rate Limit API](http://developer.github.com/v3/rate_limit/).

#### Get All Rate Limits

##### new way
```php
/** @var \Github\Api\RateLimit\RateLimitResource[] $rateLimits */
$rateLimits = $client->api('rate_limit')->getResources();
```

var_dump() output:
```
array(4) {
  ["core"]=>
  object(Github\Api\RateLimit\RateLimitResource)#30 (4) {
    ["name":"Github\Api\RateLimit\RateLimitResource":private]=>
    string(4) "core"
    ["limit":"Github\Api\RateLimit\RateLimitResource":private]=>
    int(5000)
    ["reset":"Github\Api\RateLimit\RateLimitResource":private]=>
    int(1566137712)
    ["remaining":"Github\Api\RateLimit\RateLimitResource":private]=>
    int(5000)
  }
  ["search"]=>
  object(Github\Api\RateLimit\RateLimitResource)#32 (4) {
    ["name":"Github\Api\RateLimit\RateLimitResource":private]=>
    string(6) "search"
    ["limit":"Github\Api\RateLimit\RateLimitResource":private]=>
    int(30)
    ["reset":"Github\Api\RateLimit\RateLimitResource":private]=>
    int(1566134172)
    ["remaining":"Github\Api\RateLimit\RateLimitResource":private]=>
    int(30)
  }
  ["graphql"]=>
  object(Github\Api\RateLimit\RateLimitResource)#43 (4) {
    ["name":"Github\Api\RateLimit\RateLimitResource":private]=>
    string(7) "graphql"
    ["limit":"Github\Api\RateLimit\RateLimitResource":private]=>
    int(5000)
    ["reset":"Github\Api\RateLimit\RateLimitResource":private]=>
    int(1566137712)
    ["remaining":"Github\Api\RateLimit\RateLimitResource":private]=>
    int(5000)
  }
  ["integration_manifest"]=>
  object(Github\Api\RateLimit\RateLimitResource)#44 (4) {
    ["name":"Github\Api\RateLimit\RateLimitResource":private]=>
    string(20) "integration_manifest"
    ["limit":"Github\Api\RateLimit\RateLimitResource":private]=>
    int(5000)
    ["reset":"Github\Api\RateLimit\RateLimitResource":private]=>
    int(1566137712)
    ["remaining":"Github\Api\RateLimit\RateLimitResource":private]=>
    int(5000)
  }
}
```


##### deprecated way

```php
/** @var array $rateLimits */
$rateLimits = $client->api('rate_limit')->getRateLimits();
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
