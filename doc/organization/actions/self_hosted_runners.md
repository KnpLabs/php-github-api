## Organization / Actions / Self Hosted Runners API
[Back to the "Organization API"](../../organization.md) | [Back to the navigation](../../README.md)

# List self-hosted runners for an Organization

https://docs.github.com/en/rest/actions/self-hosted-runners?apiVersion=2022-11-28#list-self-hosted-runners-for-an-organization

```php
$runners = $client->api('organization')->runners()->all('KnpLabs');
```

# Get a self-hosted runner for an Organization

 https://docs.github.com/en/rest/actions/self-hosted-runners?apiVersion=2022-11-28#get-a-self-hosted-runner-for-an-organization

```php
$runner = $client->api('organization')->runners()->show('KnpLabs', $runnerId);
```

# Delete a self-hosted runner from an Organization

https://docs.github.com/en/rest/actions/self-hosted-runners?apiVersion=2022-11-28#delete-a-self-hosted-runner-from-an-organization

```php
$client->api('organization')->runners()->remove('KnpLabs', $runnerId);
```

# List runner applications for an Organization

https://docs.github.com/en/rest/actions/self-hosted-runners?apiVersion=2022-11-28#list-runner-applications-for-an-organization

```php
$applications = $client->api('organization')->selfHostedRunners()->applications('KnpLabs');
```

# List of all runners with Pagination

```php
$api = $github->api('organization')->runners();
$paginator  = new Github\ResultPager($github);
$parameters = array('KnpLabs');
$runners = $paginator->fetchAll($api, 'all', $parameters);

do {
    foreach ($runners['runners'] as $runner) {
        // code
    }
    $runners = $paginator->fetchNext();
}
while($paginator->hasNext());
```
