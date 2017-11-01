## Repo / Protection API
[Back to the "Repos API"](../repos.md) | [Back to the navigation](../README.md)

The Protection API is currently available for developers to preview.
To access the API during the preview period, you must provide a custom media type in the Accept header:

```php
$client->api('repo')->protection()->configure();
```

### List all branch protection

> Requires [authentication](../security.md).

```php
$protection = $client->api('repo')->protection()->show('twbs', 'bootstrap', 'master');
```

### Update branch protection

> Requires [authentication](../security.md).

For the full list of parameters see https://developer.github.com/v3/repos/branches/#parameters-1

```php
$params = [
    'required_status_checks' => null,
    'required_pull_request_reviews' => [
        'include_admins' => true,
    ],
    'enforce_admins' => true,
    'restrictions' => null,
];
$protection = $client->api('repo')->protection()->update('twbs', 'bootstrap', 'master', $params);
```

### Remove branch protection

> Requires [authentication](../security.md).

```php
$protection = $client->api('repo')->protection()->remove('twbs', 'bootstrap', 'master');
```

### Get required status checks of protected branch

> Requires [authentication](../security.md).

```php
$protection = $client->api('repo')->protection()->showStatusChecks('twbs', 'bootstrap', 'master');
```

### Update required status checks of protected branch

> Requires [authentication](../security.md).

```php
$params = [
    'strict' => true,
    'contexts' => [
        'continuous-integration/travis-ci',
    ],
];
$protection = $client->api('repo')->protection()->updateStatusChecks('twbs', 'bootstrap', 'master', $params);
```

### Remove required status checks of protected branch

> Requires [authentication](../security.md).

```php
$protection = $client->api('repo')->protection()->removeStatusChecks('twbs', 'bootstrap', 'master');
```

### List required status checks contexts of protected branch

> Requires [authentication](../security.md).

```php
$protection = $client->api('repo')->protection()->showStatusChecksContexts('twbs', 'bootstrap', 'master');
```

### Replace required status checks contexts of protected branch

> Requires [authentication](../security.md).

```php
$params = [
    'continuous-integration/travis-ci',
];
$protection = $client->api('repo')->protection()->replaceStatusChecksContexts('twbs', 'bootstrap', 'master', $params);
```

### Add required status checks contexts of protected branch

> Requires [authentication](../security.md).

```php
$params = [
    'continuous-integration/jenkins',
];
$protection = $client->api('repo')->protection()->addStatusChecksContexts('twbs', 'bootstrap', 'master', $params);
```

### Remove required status checks contexts of protected branch

> Requires [authentication](../security.md).

```php
$params = [
    'continuous-integration/jenkins',
];
$protection = $client->api('repo')->protection()->removeStatusChecksContexts('twbs', 'bootstrap', 'master', $params);
```

### Get pull request review enforcement of protected branch

> Requires [authentication](../security.md).

```php
$protection = $client->api('repo')->protection()->showPullRequestReviewEnforcement('twbs', 'bootstrap', 'master');
```

### Update pull request review enforcement of protected branch

> Requires [authentication](../security.md) with admin access and branch protection to be enabled.

```php
$params = [
    'dismissal_restrictions' => [
        'users' => [
            'octocat',
        ],
        'teams' => [
            'justice-league',
        ],
    ],
    'dismiss_stale_reviews' => true,
    'require_code_owner_reviews' => true,
];
$protection = $client->api('repo')->protection()->updatePullRequestReviewEnforcement('twbs', 'bootstrap', 'master', $params);
```

### Remove pull request review enforcement of protected branch

> Requires [authentication](../security.md).

```php
$protection = $client->api('repo')->protection()->removePullRequestReviewEnforcement('twbs', 'bootstrap', 'master');
```

### Get admin enforcement of protected branch


> Requires [authentication](../security.md).

```php
$protection = $client->api('repo')->protection()->showAdminEnforcement('twbs', 'bootstrap', 'master');
```

### Add admin enforcement of protected branch

> Requires [authentication](../security.md) with admin access and branch protection to be enabled.

```php
$protection = $client->api('repo')->protection()->addAdminEnforcement('twbs', 'bootstrap', 'master');
```

### Remove admin enforcement of protected branch

> Requires [authentication](../security.md) with admin access and branch protection to be enabled.

```php
$protection = $client->api('repo')->protection()->removeAdminEnforcement('twbs', 'bootstrap', 'master');
```

### Get restrictions of protected branch

> Requires [authentication](../security.md) and is only available for organization-owned repositories.

```php
$protection = $client->api('repo')->protection()->showRestrictions('twbs', 'bootstrap', 'master');
```

### Remove restrictions of protected branch

> Requires [authentication](../security.md) and is only available for organization-owned repositories.

```php
$protection = $client->api('repo')->protection()->removeRestrictions('twbs', 'bootstrap', 'master');
```

### List team restrictions of protected branch

> Requires [authentication](../security.md) and is only available for organization-owned repositories.

```php
$protection = $client->api('repo')->protection()->showTeamRestrictions('twbs', 'bootstrap', 'master');
```

### Replace team restrictions of protected branch

> Requires [authentication](../security.md) and is only available for organization-owned repositories.

```php
$params = [
    'justice-league',
];
$protection = $client->api('repo')->protection()->replaceTeamRestrictions('twbs', 'bootstrap', 'master', $params);
```

### Add team restrictions of protected branch

> Requires [authentication](../security.md) and is only available for organization-owned repositories.

```php
$params = [
    'justice-league',
];
$protection = $client->api('repo')->protection()->addTeamRestrictions('twbs', 'bootstrap', 'master', $params);
```

### Remove team restrictions of protected branch

> Requires [authentication](../security.md) and is only available for organization-owned repositories.

```php
$params = [
    'octocats',
];
$protection = $client->api('repo')->protection()->removeTeamRestrictions('twbs', 'bootstrap', 'master', $params);
```

### List user restrictions of protected branch

> Requires [authentication](../security.md) and is only available for organization-owned repositories.

```php
$protection = $client->api('repo')->protection()->showUserRestrictions('twbs', 'bootstrap', 'master');
```

### Replace user restrictions of protected branch

> Requires [authentication](../security.md) and is only available for organization-owned repositories.

```php
$params = [
    'octocat',
];
$protection = $client->api('repo')->protection()->replaceUserRestrictions('twbs', 'bootstrap', 'master', $params);
```

### Add user restrictions of protected branch

> Requires [authentication](../security.md) and is only available for organization-owned repositories.

```php
$params = [
    'octocat',
];
$protection = $client->api('repo')->protection()->addUserRestrictions('twbs', 'bootstrap', 'master', $params);
```

### Remove user restrictions of protected branch

> Requires [authentication](../security.md) and is only available for organization-owned repositories.

```php
$params = [
    'defunkt',
];
$protection = $client->api('repo')->protection()->removeUserRestrictions('twbs', 'bootstrap', 'master', $params);
```
