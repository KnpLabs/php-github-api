## User / Migrations API
[Back to the "Users API"](../../users.md) | [Back to the navigation](../../README.md)

# List user migrations

https://docs.github.com/rest/migrations/users#list-user-migrations

```php
$api = $github->api('user')->migration();
$paginator  = new Github\ResultPager($github);
$parameters = [];
$migrations = $paginator->fetchAll($api, 'list', $parameters);

do {
    foreach ($migrations as $migration) {
        // do something
    }
    $migrations = $paginator->fetchNext();
}
while($paginator->hasNext());
```

# Start a User Migration

https://docs.github.com/rest/migrations/users#start-a-user-migration

```php
$client->users()->migration()->start([
    'repositories' => [
        'KnpLabs/php-github-api'
    ],
    'lock_repositories' => true,
    'exclude_metadata' => false,
    'exclude_git_data' => false,
    'exclude_attachments' => true,
    'exclude_releases' => false,
    'exclude_owner_projects' => true,
    'org_metadata_only' => false,
    'exclude' => [
        'Exclude attributes from the API response to improve performance'
    ]
]);
```

# Get a User Migration Status

https://docs.github.com/rest/migrations/users#get-a-user-migration-status

```php
$status = $client->user()->migration()->status(12, [
    'exclude' => [
        'exclude attributes'
    ]
]);
```

# Delete a User Migration Archive

https://docs.github.com/rest/migrations/users#delete-a-user-migration-archive

```php
$client->user()->migration()->deleteArchive(12);
```

# Unlock a User Repository

https://docs.github.com/rest/migrations/users#unlock-a-user-repository

```php
$client->user()->migration()->unlockRepo(12, 'php-github-api');
```

# List repositories for a User Migration

https://docs.github.com/rest/migrations/users#list-repositories-for-a-user-migration

```php
$repos = $client->user()->migration()->repos(2);
```
