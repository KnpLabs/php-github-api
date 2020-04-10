## Request any Route
[Back to the navigation](README.md)

The method you need does not exist yet? You can access any GitHub route by using the "get" and "post" methods.
For example, the following snippet returns an array describing the "php-github-api" repository.

```php
$client   = new Github\Client();
$response = $client->getHttpClient()->get('repos/KnpLabs/php-github-api');
$repo     = Github\HttpClient\Message\ResponseMediator::getContent($response);
```

If you need to call any methods on the HTTP client before sending a request, for example setting a header you can access the HTTP client builder, call any methods and then get the configured client. For example, the following snippet gets the builder, adds a header and then performs a "put" request.

```php
$client = new Github\Client()

$builder = $client->getHttpClientBuilder();

$builder->addHeaders(['Content-Length' => 0]);

$client = $builder->getHttpClient()

$response = $client->put('user/starred/:owner/:repo')

$content = Github\HttpClient\Message\ResponseMediator::getContent($response);
```

See all GitHub API routes: [http://developer.github.com/](http://developer.github.com/)
