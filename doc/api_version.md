## Api version
[Back to the navigation](README.md)

If you want to change the API version from its default ("v3") you may do that with a constructor argument.
For example:

```php
$client = new Github\Client();
echo $client->getApiVersion(); // prints "v3"

$client = new Github\Client(new Github\HttpClient\Builder($httpClient), 'v2');
echo $client->getApiVersion(); // prints "v2"
```
