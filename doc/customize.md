## Customize `php-github-api` and testing
[Back to the navigation](index.md)

### Configure the http client

Wanna change, let's say, the http client User Agent?

```php
<?php

$client->getHttpClient()->setOption('user_agent', 'My new User Agent');
```

See all available options in `Github/HttpClient/HttpClient.php`

### Inject a new http client instance

`php-github-api` provides a curl-based implementation of a http client.
If you want to use your own http client implementation, inject it to the `Github\Client` instance:

```php
<?php

use Github\HttpClient\HttpClient;

// create a custom http client
class MyHttpClient extends HttpClient
{
    public function doRequest($url, array $parameters = array(), $httpMethod = 'GET', array $options = array())
    {
        // send the request and return the raw response
    }
}
```

> Your http client implementation may not extend `Github\HttpClient\HttpClient`, but only implement `Github\HttpClient\HttpClientInterface`.

You can now inject your http client through `Github\Client` constructor:

```php
<?php

$client = new Github\Client(new MyHttpClient());
```

Or to an existing Github_Client instance:

```php
<?php

$client->setHttpClient(new MyHttpClient());
```

### Run Test Suite

The code is unit tested, there are also some functional tests. To run tests on your machine, from a CLI, run

```bash
$ phpunit
```
