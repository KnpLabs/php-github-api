## Result Pager
[Back to the navigation](index.md)

### Usage examples

Get all repositories of a organization

```php
$client = new Github\Client();

$organizationApi = $client->api('organization');

$paginator  = new Github\ResultPager($client);
$parameters = array('github');
$result     = $paginator->fetchAll($organizationApi, 'repositories', $parameters);
```

Get the first page
```php
$client = new Github\Client();

$organizationApi = $client->api('organization');

$paginator  = new Github\ResultPager( $client );
$parameters = array('github');
$result     = $paginator->fetch($organizationApi, 'repositories', $parameters);
```

Check for a next page:
```php
$paginator->hasNext();
```

Get next page:
```php
$paginator->fetchNext();
```

Check for previous page:
```php
$paginator->hasPrevious();
```

Get previous page:
```php
$paginator->fetchPrevious();
```

If you want to retrieve the pagination links (available after the call to fetch):
```php
$paginator->getPagination();
```
