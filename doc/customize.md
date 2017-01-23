## Customize `php-github-api`
[Back to the navigation](README.md)


### Inject a new HTTP client instance

`php-github-api` relies on `php-http/discovery` to find an installed HTTP client. You may specify a HTTP client
yourself by calling `\Github\Client::setHttpClient`. A HTTP client must implement `Http\Client\HttpClient`. A list of
community provided clients is found here: https://packagist.org/providers/php-http/client-implementation

You can inject a HTTP client through the `Github\Client` constructor:

```php
$client = Github\Client::createWithHttpClient(new Http\Adapter\Guzzle6\Client());
```

### Configure the HTTP client

Wanna change, let's say, the HTTP client User Agent? You need to create a Plugin that modifies the
request. Read more about [HTTPlug plugins here](http://docs.php-http.org/en/latest/plugins/introduction.html#how-it-works).

```php
use Http\Client\Common\Plugin;
use Psr\Http\Message\RequestInterface;

class CustomUserAgentPlugin implements Plugin
{
    /**
     * {@inheritdoc}
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first)
    {
        $request->withHeader('user-agent', 'Foobar');

        return $next($request);
    }
}

$httpBuilder = new Github\HttpClient\Builder(new Http\Adapter\Guzzle6\Client());
$httpBuilder->addPlugin(new CustomUserAgentPlugin());

$client = new Github\Client($httpBuilder);
```
