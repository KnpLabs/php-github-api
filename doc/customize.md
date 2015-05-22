## Customize `php-github-api` and testing
[Back to the navigation](README.md)

### Configure the http client

Wanna change, let's say, the http client User Agent?

```php
$client->getHttpClient()->setOption('user_agent', 'My new User Agent');
```

See all available options in `Github/HttpClient/HttpClient.php`

### Guzzle events

If you need to perform any special action on request/response use guzzle events:

```php
use Guzzle\Common\Event;
use Github\HttpClient\Message\ResponseMediator;

$client->getHttpClient()->addListener('request.success', function(Event $event) {
   $remaining = ResponseMediator::getApiLimit($event['response']);

    var_dump($remaining);
});

$client->user()->show('cursedcoder');
```

see list of events http://guzzle3.readthedocs.org/http-client/request.html#plugins-and-events

### Inject a new http client instance

`php-github-api` provides a curl-based implementation of a http client.
If you want to use your own http client implementation, inject it to the `Github\Client` instance:

```php
use Github\HttpClient\HttpClient;

// create a custom http client
class MyHttpClient extends HttpClient
{
    public function request($url, array $parameters = array(), $httpMethod = 'GET', array $headers = array())
    {
        // send the request and return the raw response
    }
}
```

> Your http client implementation may not extend `Github\HttpClient\HttpClient`, but only implement `Github\HttpClient\HttpClientInterface`.

You can now inject your http client through `Github\Client#setHttpClient()` method:

```php
$client = new Github\Client();
$client->setHttpClient(new MyHttpClient());
```

### Run Test Suite

The code is unit tested, there are also some functional tests. To run tests on your machine, from a CLI, run

```bash
$ phpunit
```
