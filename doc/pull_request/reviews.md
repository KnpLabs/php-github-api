## Pull Requests / Reviews API
[Back to the "Pull Requests API"](../pull_requests.md) | [Back to the navigation](../README.md)

### List all reviews

```php
$reviewRequests = $client->api('pull_request')->reviews()->all('twbs', 'bootstrap', 12);
```

### Create a review

```php
$client->api('pull_request')->reviews()->create('twbs', 'bootstrap', 12, array(                  
    'event' => 'APPROVE', // Accepted values: APPROVE, REQUEST_CHANGES, COMMENT, see https://developer.github.com/v3/pulls/reviews/#input-1
    'body' => 'OK, looks good :)',// Optional, the review body text
    'commit_id' => $commitSha, // Optional, default value is HEAD sha
));
```

### Get a review

```php
$client->api('pull_request')->reviews()->show('twbs', 'bootstrap', 12, $reviewId);
```

### Get comment from a review

```php
$client->api('pull_request')->reviews()->comments('twbs', 'bootstrap', 12, $reviewId);
```

### Dismiss a review
**This does not remove the review but dismisses the (dis)approval status of this one**

Note: To dismiss a pull request review on a protected branch, you must be a
repository administrator or be included in the list of people or teams who can dismiss pull request reviews.

```php
$client->api('pull_request')->reviews()->remove('twbs', 'bootstrap', 12, $reviewId, 'Dismiss reason (mandatory)');
```

### Remove a review

```php
$client->api('pull_request')->reviews()->remove('twbs', 'bootstrap', 12, $reviewId);
```
