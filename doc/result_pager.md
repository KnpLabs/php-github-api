## Result Pager
[Back to the navigation](index.md)

### Usage examples

Get all repositories of a organization

```php
$client = new Github\Client();

$organizationApi = $client->api('organization');

$paginator = new Github\ResultPager( $client );
$result    = $paginator->fetchAll( $organizationApi, 'repositories', 'github' );
```

Get the first page
```php
$client = new Github\Client();

$organizationApi = $client->api('organization');

$paginator = new Github\ResultPager( $client );
$result    = $paginator->fetch( $organizationApi, 'repositories', 'github' );
```
Check for a next page:
```php
$paginator->hasNext();
```

Get next page:
```php
$paginator->fetchNext();
```

Check for pervious page:
```php
$paginator->hasPrevious();
```

Get prevrious page:
```php
$paginator->fetchPrevious();
```