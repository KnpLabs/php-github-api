## Pagination support
[Back to the navigation](index.md)

Github API supports pagination for calls that return multiple items.

Please read official documentation by link: https://developer.github.com/v3/#pagination

There are two approaches to work with pagination using PHP Github API:
* [\Github\ResultPager](#result-pager): to iterate through collection *page by page*;
* [setPerPage() and setPageNumber() methods](#setperpage-and-setpagenumber-methods): to fetch specific page with exact number of items;

### Result Pager

#### Example: get all repositories of an organization

```php
$client = new Github\Client();

$organizationApi = $client->api('organization');

$paginator  = new Github\ResultPager($client);
$parameters = array('github');
$result     = $paginator->fetchAll($organizationApi, 'repositories', $parameters);
```

Parameters of the `fetchAll` method:

* The API object you're working with
* The method of the API object you're using
* The parameters of the method

#### Example: get the first page

```php
$client = new Github\Client();

$organizationApi = $client->api('organization');

$paginator  = new Github\ResultPager( $client );
$parameters = array('github');
$result     = $paginator->fetch($organizationApi, 'repositories', $parameters);
```

#### Example: check for a next page

```php
$paginator->hasNext();
```

#### Example: get next page

```php
$paginator->fetchNext();
```

#### Example: check for previous page

```php
$paginator->hasPrevious();
```

#### Example: get previous page:

```php
$paginator->fetchPrevious();
```

#### Example: get all available pagination links

If you want to retrieve the pagination links (available after the call to fetch):
```php
$paginator->getPagination();
```

### setPerPage() and setPageNumber() methods

If you want to retrieve exact page (for calls that return multiple items):
```php
$result = $api->setPageNumber($pageNumber)
    ->get(...);
```

Also you can control the number of items per page:
```php
$result = $api->setPerPage(3)
    ->get(...);
```
