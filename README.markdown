# PHP GitHub API

A simple, Object Oriented API wrapper for GitHub written with PHP5.

Uses [GitHub API v2](http://develop.github.com/).

Requires [php curl](http://php.net/manual/en/book.curl.php).

## Instanciate a new API

    $github = new phpGitHubApi();

### Authenticate a user

This step is facultative, as most of GitHub services do not require authentication.

    $github->authenticate('ornicar', 'my-token');

Next requests will use the user "ornicar", instead of anonymous access.

### Deauthenticate a user

Cancels authentication.

    $github->deAuthenticate();

Next requests will use anonymous access.

## Users

[Searching users, getting user information and managing authenticated user account information.](http://develop.github.com/p/users.html)

### Search for users by username

    $users = $github->getUserApi()->search('ornicar');

Returns an array of users as described in [http://develop.github.com/p/users.html#searching_for_users](http://develop.github.com/p/users.html#searching_for_users)

### Get information about a user

    $user = $github->getUserApi()->show('ornicar');

Returns an array of information about the user as described in [http://develop.github.com/p/users.html#getting_user_information](http://develop.github.com/p/users.html#getting_user_information)

## Issues

[Listing issues, searching, editing and closing your projects issues.](http://develop.github.com/p/issues.html)

### List issues in a project

    $issues = $github->getIssueApi()->getList('ornicar', 'php-github-api', 'open');

Returns an array of issues as described in [http://develop.github.com/p/issues.html#list_a_projects_issues](http://develop.github.com/p/issues.html#list_a_projects_issues)

### Search issues in a project

    $issues = $github->getIssueApi()->search('ornicar', 'php-github-api', 'closed', 'bug');

Returns an array of closed issues matching the "bug" term, as described in [http://develop.github.com/p/issues.html#search_issues](http://develop.github.com/p/issues.html#search_issues)

### Get information about an issue

    $users = $github->getIssueApi()->show('ornicar', 'php-github-api', 1);

Returns an array of information about the issue as described in [http://develop.github.com/p/issues.html#view_an_issue](http://develop.github.com/p/issues.html#view_an_issue)

## Commits

[Getting information on specific commits, the diffs they introduce, the files they've changed.](http://develop.github.com/p/commits.html)

### List commits in a branch

    $commits = $github->getCommitApi()->getBranchCommits('ornicar', 'php-github-api', 'master');

Returns an array of commits as described in [http://develop.github.com/p/commits.html#listing_commits_on_a_branch](http://develop.github.com/p/commits.html#listing_commits_on_a_branch)

### List commits for a file

    $commits = $github->getCommitApi()->getFileCommits('ornicar', 'php-github-api', 'master', 'README');

Returns an array of commits as described in [http://develop.github.com/p/commits.html#listing_commits_for_a_file](http://develop.github.com/p/commits.html#listing_commits_for_a_file)

## Objects

[Getting full versions of specific files and trees in your Git repositories.](http://develop.github.com/p/objects.html)

### List contents of a tree

    $tree = $github->getObjectApi()->showTree('ornicar', 'php-github-api', '691c2ec7fd0b948042047b515886fec40fe76e2b');

Returns an array containing a tree of the repository as described in [http://develop.github.com/p/object.html#trees](http://develop.github.com/p/object.html#trees)

### List all blobs of a tree

    $blobs = $github->getObjectApi()->listBlobs('ornicar', 'php-github-api', '691c2ec7fd0b948042047b515886fec40fe76e2b');

Returns an array containing the tree blobs as described in [http://develop.github.com/p/object.html#blobs](http://develop.github.com/p/object.html#blobs)

### Show the informations of a blob

    $blob = $github->getObjectApi()->showBlob('ornicar', 'php-github-api', '691c2ec7fd0b948042047b515886fec40fe76e2b', 'CHANGELOG');

Returns array of blob informations as described in [http://develop.github.com/p/object.html#blobs](http://develop.github.com/p/object.html#blobs)

### Show the raw content of an object

    $rawText = $github->getObjectApi()->getRawData('ornicar', 'php-github-api', 'bd25d1e4ea7eab84b856131e470edbc21b6cd66b');

The last parameter can be either a blob SHA1, a tree SHA1 or a commit SHA1.
Returns the raw text content of the object as described in [http://develop.github.com/p/object.html#raw_git_data](http://develop.github.com/p/object.html#raw_git_data)

## Request any route

The method you need does not exist yet?
You can access any GitHub route by using the "get" and "post" methods.
For example,

    $repo = $github->get('repos/show/ornicar/php-github-api');

Returns an array describing the php-github-api repository.

See all GitHub API routes: [http://develop.github.com/](http://develop.github.com/)

## Configure the request

Wanna change, let's say, the request User Agent?

    $github->getRequest()->setOption('user_agent', 'My new User Agent');

See all request available options in request/phpGitHubApiRequest.php

## Inject a new request instance

If you want to use your own request implementation, inject it to the GitHubApi:

    $github->setRequest($myRequest);

$myRequest must extend phpGitHubApiRequest.

## Inject a new API part instance

If you want to use your own implementation of the user API, inject it to the GitHubApi:

    $github->setApi('user', $myUserApi);

$myUserApi should extend phpGitHubApiUser.

## Run test suite

All code is fully unit tested. To run tests on your server, from a CLI, run

    php /path/to/php-github-api/test/prove.php

## Credits

This library borrows ideas, code and tests from [phptwitterbot](http://code.google.com/p/phptwitterbot/).

Thanks to [noloh](http://github.com/noloh) for his contribution on the Object API.

Thanks to GitHub for the high quality API and documentation.