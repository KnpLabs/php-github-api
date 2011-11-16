# PHP GitHub API

A simple Object Oriented wrapper for GitHub API, written with PHP5. 

```php
    $github = new Github_Client();
    $myRepos = $github->getRepoApi()->getUserRepos('ornicar');
```

Uses [GitHub API v2](http://develop.github.com/). The object API is very similar to the RESTful API.

## Features

* Covers 100% of GitHub API with PHP methods
* Supports 3 authentication methods
* Follows PEAR conventions and coding standard: autoload friendly
* Light and fast thanks to lazy loading of API classes
* Flexible and extensible thanks to dependency injection
* Extensively tested and documented

## Requirements

* PHP 5.2 or 5.3.
* [php curl](http://php.net/manual/en/book.curl.php), but it is possible to write another transport layer.
* PHPUnit to run tests.

## Autoload

The first step to use php-github-api is to register its autoloader:

```php
    require_once '/path/to/lib/Github/Autoloader.php';
    Github_Autoloader::register();
```

Replace the `/path/to/lib/` path with the path you used for php-github-api installation.

> php-github-api follows the PEAR convention names for its classes, which means you can easily integrate php-github-api classes loading in your own autoloader.

## instantiate a new github client

```php
    $github = new Github_Client();
```

From this object, you can access to all GitHub apis, listed below.

<a name='nav'></a>
## Navigation

[Users][] | [Issues][] | [Commits][] | [Objects][] | [Repos][] | [Pull Requests][] | [Request any Route][] | [Authentication & Security][] | [Customize php-github-api][] | [Run Test Suite][]

<a name='users'></a>
## Users
<a href='#nav' alt='Back to the navigation'>Go back to the Navigation</a>

Searching users, getting user information and managing authenticated user account information.
Wrap [GitHub User API](http://develop.github.com/p/users.html).

### Search for users by username

```php
    $users = $github->getUserApi()->search('ornicar');
```

Returns an array of users.

### Get information about a user

```php
    $user = $github->getUserApi()->show('ornicar');
```

Returns an array of information about the user.

### Update user informations

Change user attributes: name, email, blog, company, location. Requires authentication.

```php
    $github->getUserApi()->update('ornicar', array('location' => 'France', 'blog' => 'http://diem-project.org/blog'));
```

Returns an array of information about the user.

### Get users that a specific user is following

```php
    $users = $github->getUserApi()->getFollowing('ornicar');
```

Returns an array of followed users.

### Get users following a specific user

```php
    $users = $github->getUserApi()->getFollowers('ornicar');
```

Returns an array of following users.

### Follow a user

Make the authenticated user follow a user. Requires authentication.

```php
    $github->getUserApi()->follow('symfony');
```

Returns an array of followed users.

### Unfollow a user

Make the authenticated user unfollow a user. Requires authentication.

```php
    $github->getUserApi()->unFollow('symfony');
```

Returns an array of followed users.

### Get repos that a specific user is watching

```php
    $users = $github->getUserApi()->getWatchedRepos('ornicar');
```

Returns an array of watched repos.

### Get the authenticated user emails

```php
    $emails = $github->getUserApi()->getEmails();
```

Returns an array of the authenticated user emails. Requires authentication.

### Add an email to the authenticated user

```php
    $github->getUserApi()->addEmail('my-email@provider.org');
```

Returns an array of the authenticated user emails. Requires authentication.

### Remove an email from the authenticated user

```php
    $github->getUserApi()->removeEmail('my-email@provider.org');
```

Return an array of the authenticated user emails. Requires authentication.

<a name='issues'></a>
## Issues
<a href='#nav' alt='Back to the navigation'>Go back to the Navigation</a>

Listing issues, searching, editing and closing your projects issues.
Wrap [GitHub Issue API](http://develop.github.com/p/issues.html).

### List issues in a project

```php
    $issues = $github->getIssueApi()->getList('ornicar', 'php-github-api', 'open');
```

Returns an array of issues.

### Search issues in a project

```php
    $issues = $github->getIssueApi()->search('ornicar', 'php-github-api', 'closed', 'bug');
```

Returns an array of closed issues matching the "bug" term,.

### Get information about an issue

```php
    $issue = $github->getIssueApi()->show('ornicar', 'php-github-api', 1);
```

Returns an array of information about the issue.

### Open a new issue

```php
    $github->getIssueApi()->open('ornicar', 'php-github-api', 'The issue title', 'The issue body');
```

Creates a new issue in the repo "php-github-api" of the user "ornicar".
The issue is assigned to the authenticated user. Requires authentication.
Returns an array of information about the issue.

### Close an issue

```php
    $github->getIssueApi()->close('ornicar', 'php-github-api', 4);
```

Closes the fourth issue of the repo "php-github-api" of the user "ornicar". Requires authentication.
Returns an array of information about the issue.

### Reopen an issue

```php
    $github->getIssueApi()->reOpen('ornicar', 'php-github-api', 4);
```

Reopens the fourth issue of the repo "php-github-api" of the user "ornicar". Requires authentication.
Returns an array of information about the issue.

### Update an issue

```php
    $github->getIssueApi()->update('ornicar', 'php-github-api', 4, array('body' => 'The new issue body'));
```

Updates the fourth issue of the repo "php-github-api" of the user "ornicar". Requires authentication.
Available attributes are title and body.
Returns an array of information about the issue.

### List an issue comments

```php
    $comments = $github->getIssueApi()->getComments('ornicar', 'php-github-api', 4);
```

List an issue comments by username, repo and issue number.
Returns an array of issues.

### Add a comment on an issue

```php
    $github->getIssueApi()->addComment('ornicar', 'php-github-api', 4, 'My new comment');
```

Add a comment to the issue by username, repo and issue number.
The comment is assigned to the authenticated user. Requires authentication.

### List project labels

```php
    $labels = $github->getIssueApi()->getLabels('ornicar', 'php-github-api');
```

List all project labels by username and repo.
Returns an array of project labels.

### Add a label on an issue

```php
    $github->getIssueApi()->addLabel('ornicar', 'php-github-api', 'label name', 4);
```

Add a label to the issue by username, repo, label name and issue number. Requires authentication.
If the label is not yet in the system, it will be created.
Returns an array of the issue labels.

### Remove a label from an issue

```php
    $github->getIssueApi()->removeLabel('ornicar', 'php-github-api', 'label name', 4);
```

Remove a label from the issue by username, repo, label name and issue number. Requires authentication.
Returns an array of the issue labels.

### Search issues matching a label

```php
    $github->getIssueApi()->searchLabel('ornicar', 'php-github-api', 'label name')
```

Returns an array of issues matching the given label.

<a name='commits'></a>
## Commits
<a href='#nav' alt='Back to the navigation'>Go back to the Navigation</a>

Getting information on specific commits, the diffs they introduce, the files they've changed.
Wrap [GitHub Commit API](http://develop.github.com/p/commits.html).

### List commits in a branch

```php
    $commits = $github->getCommitApi()->getBranchCommits('ornicar', 'php-github-api', 'master');
```

Returns an array of commits.

### List commits for a file

```php
    $commits = $github->getCommitApi()->getFileCommits('ornicar', 'php-github-api', 'master', 'README');
```

Returns an array of commits.

### Get a single commit

```php
    $commit = $github->getCommitApi()->getCommit('ornicar', 'php-github-api', '726eac09a3b44411bd86');
```

Returns a single commit.

<a name='objects'></a>
## Objects
<a href='#nav' alt='Back to the navigation'>Go back to the Navigation</a>

Getting full versions of specific files and trees in your Git repositories. Wrap [GitHub objects API](http://develop.github.com/p/objects.html).

### List contents of a tree

```php
    $tree = $github->getObjectApi()->showTree('ornicar', 'php-github-api', '691c2ec7fd0b948042047b515886fec40fe76e2b');
```

Returns an array containing a tree of the repository.

### List all blobs of a tree

```php
    $blobs = $github->getObjectApi()->listBlobs('ornicar', 'php-github-api', '691c2ec7fd0b948042047b515886fec40fe76e2b');
```

Returns an array containing the tree blobs.

### Show the informations of a blob

```php
    $blob = $github->getObjectApi()->showBlob('ornicar', 'php-github-api', '691c2ec7fd0b948042047b515886fec40fe76e2b', 'CHANGELOG');
```

Returns array of blob informations.

### Show the raw content of an object

```php
    $rawText = $github->getObjectApi()->getRawData('ornicar', 'php-github-api', 'bd25d1e4ea7eab84b856131e470edbc21b6cd66b');
```

The last parameter can be either a blob SHA1, a tree SHA1 or a commit SHA1.
Returns the raw text content of the object.

<a name='repos'></a>
## Repos
<a href='#nav' alt='Back to the navigation'>Go back to the Navigation</a>

Searching repositories, getting repository information and managing repository information for authenticated users.
Wrap [GitHub Repo API](http://develop.github.com/p/repo.html). All methods are described on that page.

### Search repos by keyword

#### Simple search

```php
    $repos = $github->getRepoApi()->search('symfony');
```

Returns a list of repositories.

#### Advanced search

You can filter the results by language. It takes the same values as the language drop down on [http://github.com/search](http://github).

```php
    $repos = $github->getRepoApi()->search('chess', 'php');
```

You can specify the page number:

```php
    $repos = $github->getRepoApi()->search('chess' , 'php', 2);
```

### Get extended information about a repository

```php
    $repo = $github->getRepoApi()->show('ornicar', 'php-github-api')
```

Returns an array of information about the specified repository.

### Get the repositories of a specific user

```php
    $repos = $github->getRepoApi()->getUserRepos('ornicar');
```

Returns a list of repositories.

### Get the repositories the authenticated user can push to

```php
    $repos = $github->getRepoApi()->getPushableRepos();
```

Returns a list of repositories.

### Create a repository

```php
    $repo = $github->getRepoApi()->create('my-new-repo', 'This is the description of a repo', 'http://my-repo-homepage.org', true);
```

Creates and returns a public repository named my-new-repo.

### Update a repository

```php
    $repo = $github->getRepoApi()->setRepoInfo('username', 'my-new-repo', array('description' => 'some new description'));
```

The value array also accepts the parameters
 * description
 * homepage
 * has_wiki
 * has_issues
 * has_downloads

Updates and returns the repository named 'my-new-repo' that is owned by 'username'.

### Delete a repository

```php
    $token = $github->getRepoApi()->delete('my-new-repo'); // Get the deletion token
    $github->getRepoApi()->delete('my-new-repo', $token);  // Confirm repository deletion
```

Deletes the my-new-repo repository.

### Making a repository public or private

```php
    $github->getRepoApi()->setPublic('reponame');
    $github->getRepoApi()->setPrivate('reponame');
```

Makes the 'reponame' repository public or private and returns the repository.

### Get the deploy keys of a repository

```php
    $keys = $github->getRepoApi()->getDeployKeys('reponame');
```

Returns a list of the deploy keys for the 'reponame' repository.

### Add a deploy key to a repository

```php
    $keys = $github->getRepoApi()->addDeployKey('reponame', 'key title', $key);
```

Adds a key with title 'key title' to the 'reponame' repository and returns a list of the deploy keys for the repository.

### Remove a deploy key from a repository

```php
    $keys = $github->getRepoApi()->removeDeployKey('reponame', 12345);
```

Removes the key with id 12345 from the 'reponame' repository and returns a list of the deploy keys for the repository.

### Get the collaborators for a repository

```php
    $collaborators = $github->getRepoApi()->getRepoCollaborators('username', 'reponame');
```

Returns a list of the collaborators for the 'reponame' repository.

### Add a collaborator to a repository

```php
    $collaborators = $github->getRepoApi->addCollaborator('reponame', 'username');
```

Adds the 'username' user as collaborator to the 'reponame' repository.

### Remove a collaborator from a repository

```php
    $collaborators = $github->getRepoApi->removeCollaborator('reponame', 'username');
```

Remove the 'username' collaborator from the 'reponame' repository.

### Watch and unwatch a repository

```php
    $repository = $github->getRepoApi->watch('ornicar', 'php-github-api');
    $repository = $github->getRepoApi->unwatch('ornicar', 'php-github-api');
```

Watches or unwatches the 'php-github-api' repository owned by 'ornicar' and returns the repository.

### Fork a repository

```php
    $repository = $github->getRepoApi->fork('ornicar', 'php-github-api');
```

Creates a fork of the 'php-github-api' owned by 'ornicar' and returns the newly created repository.

### Get the tags of a repository

```php
    $tags = $github->getRepoApi()->getRepoTags('ornicar', 'php-github-api');
```

Returns a list of tags.

### Get the branches of a repository

```php
    $tags = $github->getRepoApi()->getRepoBranches('ornicar', 'php-github-api');
```

Returns a list of branches.

### Get the watchers of a repository

```php
    $watchers = $github->getRepoApi()->getRepoWatchers('ornicar', 'php-github-api');
```

Returns list of the users watching the 'php-github-api' owned by 'ornicar'.

### Get the network (forks) of a repository

```php
    $network = $github->getRepoApi()->getRepoNetwork('ornicar', 'php-github-api');
```

Returns list of the forks of the 'php-github-api' owned by 'ornicar', including the original repository.

### Get the languages for a repository

```php
    $contributors = $github->getRepoApi()->getRepoLanguages('ornicar', 'php-github-api');
```

Returns a list of languages.

### Get the contributors of a repository

```php
    $contributors = $github->getRepoApi()->getRepoContributors('ornicar', 'php-github-api');
```

Returns a list of contributors.

To include non GitHub users, add a third parameter to true:

```php
    $contributors = $github->getRepoApi()->getRepoContributors('ornicar', 'php-github-api', true);
```




<a name='pull_requests'></a>
## Pull Requests
<a href='#nav' alt='Back to the navigation'>Go back to the Navigation</a>

Lets you list pull requests for a given repository, list one pull request in particular along with its discussion, and create a pull-request. 
Wraps [GitHub Pull Request API](http://develop.github.com/p/pulls.html), still tagged **BETA**. All methods are described there.

### List all pull requests, per repository

#### List open pull requests

```php
    $openPullRequests = $github->getPullRequestApi()->listPullRequests( "ezsystems", "ezpublish", 'open' );
```

The last parameter of the listPullRequests method default to 'open'. The call above is equivalent to : 

```php
    $openPullRequests = $github->getPullRequestApi()->listPullRequests( "ezsystems", "ezpublish" );
```

``$openPullRequests`` contains an array of open pull-requests for this repository.

#### List closed pull requests

```php
    $closedPullRequests = $github->getPullRequestApi()->listPullRequests( "ezsystems", "ezpublish", 'closed' );
```

``$closedPullRequests`` contains an array of closed pull-requests for this repository.

### List one pull request in particular, along with its discussion

```php
    $pullRequest15 = $github->getPullRequestApi()->show( "ezsystems", "ezpublish", 15 );
```

The last parameter of this call, Pull request ID, can be either extracted from the results of the 
``listPullRequests`` results ( 'number' key for a listed pull-request ), or added manually. 

The ``$pullRequest15`` array contains the same elements as every entry in the result of a ``listPullRequests`` call, plus a "discussion" key, self-explanatory.

### Create a pull request

A pull request can either be created by supplying both the Title & Body, OR an Issue ID.
Details regarding the content of parameters 3 and 4 of the ``create`` method are presented here : http://develop.github.com/p/pulls.html .

#### Populated with Title and Body

Requires authentication.

```php
    $title = "My nifty pull request";
    $body  = "This pull request contains a bunch of enhancements and bug-fixes, happily shared with you";
    $github->getPullRequestApi()->create( "ezsystems", "ezpublish", "master", "testbranch", $title, $body );
```

This returns the details of the pull request.

#### Populated with Issue ID

Requires authentication. The issue ID is provided instead of title and body. 

```php
    $issueId = 15;
    $github->getPullRequestApi()->create( "ezsystems", "ezpublish", "master", "testbranch", null, null, $issueId );
```

This returns the details of the pull request.


<a name='request_any_route'></a>
## Request any Route
<a href='#nav' alt='Back to the navigation'>Go back to the Navigation</a>

The method you need does not exist yet?
You can access any GitHub route by using the "get" and "post" methods.
For example,

```php
    $repo = $github->get('repos/show/ornicar/php-github-api');
```

Returns an array describing the php-github-api repository.

See all GitHub API routes: [http://develop.github.com/](http://develop.github.com/)

<a name='authentication_and_security'></a>
## Authentication & Security
<a href='#nav' alt='Back to the navigation'>Go back to the Navigation</a>

Most GitHub services do not require authentication, but some do. For example the methods that allow you to change properties on Repositories and some others. Therefore this step is facultative.

### Authenticate

GitHub provides some different ways of authentication. This API implementation implements three of them which are handled by one function:

```php
    $github->authenticate($username, $secret, $method);
```

$username is, of course, the username. $method is optional. The three allowed
values are:

* Github_Client::AUTH_URL_TOKEN (default, if $method is omitted)
* Github_Client::AUTH_HTTP_TOKEN
* Github_Client::AUTH_HTTP_PASSWORD

The required value of $secret depends on the choosen $method. For the AUTH_*_TOKEN methods, you should provide the API token here. For the AUTH_HTTP_PASSWORD, you should provide the password of the account.

After executing the `$github->authenticate($username, $secret, $method);` method using correct credentials, all further requests are done as the given user.

### About authentication methods

The Github_Client::AUTH_URL_TOKEN authentication method sends the username and API token in URL parameters. The Github_Client::AUTH_HTTP_* authentication methods send their values to GitHub using HTTP Basic Authentication. Github_Client::AUTH_URL_TOKEN used to be the only available authentication method. To prevent existing applications from changing their behavior in case of an API upgrade, this method is choosen as the default for this API implementation. Note however that GitHub describes this method as deprecated. In most case you should use the Github_Client::AUTH_HTTP_TOKEN instead.

### Deauthenticate

If you want to stop new requests from being authenticated, you can use the deAuthenticate method.

```php
    $github->deAuthenticate();
```

<a name='customize'></a>
## Customize php-github-api
<a href='#nav' alt='Back to the navigation'>Go back to the Navigation</a>

The library is highly configurable and extensible thanks to dependency injection.

### Configure the http client

Wanna change, let's say, the http client User Agent?

```php
    $github->getHttpClient()->setOption('user_agent', 'My new User Agent');
```

See all available options in Github/HttpClient.php

### Inject a new http client instance

php-github-api provides a curl-based implementation of a http client.
If you want to use your own http client implementation, inject it to the Github_Client instance:

```php
    // create a custom http client
    class MyHttpClient extends Github_HttpClient
    {
        public function doRequest($url, array $parameters = array(), $httpMethod = 'GET', array $options = array())
        {
            // send the request and return the raw response
        }
    }
```

> Your http client implementation may not extend Github_HttpClient, but only implement Github_HttpClientInterface.

You can now inject your http client through Github_Client constructor:

```php
    $github = new Github_Client(new MyHttpClient());
```

Or to an existing Github_Client instance:

```php
    $github->setHttpClient(new MyHttpClient());
```

### Inject a new API part instance

If you want to use your own implementation of an API, inject it to the GitHubApi.
For example, to replace the user API:

```php
    // create a custom User API
    class MyGithubApiUser extends Github_Api_User
    {
      // overwrite things
    }

    $github->setApi('user', new MyGithubApiUser($github));
```

<a name='run_test_suite'></a>
## Run Test Suite
<a href='#nav' alt='Back to the navigation'>Go back to the Navigation</a>

The code is unit tested. To run tests on your machine, from a CLI, run

    phpunit

## Credits

This library borrows ideas, code and tests from [phptwitterbot](http://code.google.com/p/phptwitterbot/).

### Contributors hall of fame

- Thanks to [noloh](http://github.com/noloh) for his contribution on the Object API.
- Thanks to [bshaffer](http://github.com/bshaffer) for his contribution on the Repo API.
- Thanks to [Rolf van de Krol](http://github.com/rolfvandekrol) for his countless contributions.
- Thanks to [Nicolas Pastorino](http://github.com/jeanvoye) for his contribution on the Pull Request API.

Thanks to GitHub for the high quality API and documentation.


[Users]: #users
[Issues]: #issues
[Commits]: #commits
[Objects]: #objects
[Repos]: #repos
[Pull Requests]: #pull_requests
[Request any Route]: #request_any_route
[Authentication & Security]: #authentication_and_security
[Customize php-github-api]: #customize
[Run Test Suite]: #run_test_suite
