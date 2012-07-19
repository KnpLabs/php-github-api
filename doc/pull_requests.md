## Pull Requests API
[Back to the navigation](index.md)

Additional APIs:
* [Review Comments](pull_request/comments.md)

Lets you list pull requests for a given repository, list one pull request in particular along
with its discussion, and create a pull-request.
Wraps [GitHub Pull Request API](http://developer.github.com/v3/pulls/).

### List all pull requests, per repository

#### List open pull requests

```php
<?php

$openPullRequests = $client->api('pull_request')->all('ezsystems', 'ezpublish', 'open');
```

The last parameter of the listPullRequests method default to 'open'. The call above is equivalent to:

```php
<?php

$openPullRequests = $client->api('pull_request')->all('ezsystems', 'ezpublish');
```

``$openPullRequests`` contains an array of open pull-requests for this repository.

#### List closed pull requests

```php
<?php

$closedPullRequests = $client->api('pull_request')->all('ezsystems', 'ezpublish', 'closed');
```

``$closedPullRequests`` contains an array of closed pull-requests for this repository.

### List one pull request in particular, along with its discussion

```php
<?php

$pullRequest = $client->api('pull_request')->show('ezsystems', 'ezpublish', 15);
```

The last parameter of this call, Pull Request ID.

The ``$pullRequest`` array contains the same elements as every entry in the result of a ``all()`` call, plus a "discussion" key, self-explanatory.

### Create a pull request

A pull request can either be created by supplying both the Title & Body, OR an Issue ID.
Details regarding the content of parameters 3 and 4 of the ``create``.

#### Populated with Title and Body

Requires authentication.

```php
<?php

$client->authenticate();
$pullRequest = $client->api('pull_request')->create('ezsystems', 'ezpublish', array(
    'base'  => 'master',
    'head'  => 'testbranch',
    'title' => 'My nifty pull request',
    'body'  => 'This pull request contains a bunch of enhancements and bug-fixes, happily shared with you'
);
```

This returns the details of the pull request.

#### Populated with Issue ID

Requires authentication. The issue ID is provided instead of title and body.

```php
<?php

$client->authenticate();
$pullRequest = $client->api('pull_request')->create('ezsystems', 'ezpublish', array(
    'base'  => 'master',
    'head'  => 'testbranch',
    'issue' => 15
);
```

This returns the details of the pull request.
