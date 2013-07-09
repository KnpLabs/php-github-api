## Result Pager
[Back to the navigation](index.md)

### Usage examples

Get all results of a organization

```php
$client = new Github\Client();

$organizationApi = $client->api('organization');

$paginator = new Github\ResultPager( $client );
$result    = $paginator->fetchAll( $organizationApi, 'repositories', 'future500' );
```
