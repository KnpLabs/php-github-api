## Api version
[Back to the navigation](README.md)

If you want to change the API version from its default ("v3") you may do that with
the `setApiVersion` function. 
For example:

```php
$client = new Github\Client();

echo $client->getApiVersion(); // prints "s3"

$client->setApiVersion("v2");
```
