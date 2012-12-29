## Request any Route
[Back to the navigation](index.md)

The method you need does not exist yet? You can access any GitHub route by using the "get" and "post" methods.
For example:

```php
$client = new Github\Client();
$repo   = $client->getHttpClient()->get('repos/KnpLabs/php-github-api');
```

Returns an array describing the "php-github-api" repository.

See all GitHub API routes: [http://developer.github.com/](http://developer.github.com/)
