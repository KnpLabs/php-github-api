# PHP GitHub API

A simple, Object Oriented wrapper for GitHub API written with PHP5. 

    $github = new phpGitHubApi();
    $myRepos = $github->getRepoApi()->getUserRepos('ornicar');

Uses [GitHub API v2](http://develop.github.com/). The way the Object Oriented Interface is organized is mainly inspired by the way GitHub has organized their API Documentation.

Requires [php curl](http://php.net/manual/en/book.curl.php).

## Instanciate a new API

    $github = new phpGitHubApi();

This instanciated API does not offer many function by itself, but provides methods to instanciate the different Sub-API's that GitHub defines in the API documentation. The main API object just provides methods for authentication.

### Authentication

Most GitHub services do not require authentication, but some do. For example the methods that allow you to change properties on Repositories and some others. Therefore this step is facultative.

GitHub provides some different ways of authentication. This API implementation implements three of them which are handled by one function:

    $github->authenticate($username, $secret, $method);

$username is, of course, the username. $method is optional. The three allowed
values are:

* phpGitHubApi::AUTH_URL_TOKEN (default, if $method is omitted)
* phpGitHubApi::AUTH_HTTP_TOKEN
* phpGitHubApi::AUTH_HTTP_PASSWORD

The required value of $secret depends on the choosen $method. For the AUTH_*_TOKEN methods, you should provide the API token here. For the AUTH_HTTP_PASSWORD, you should provide the password of the account.

After executing the `$github->authenticate($username, $secret, $method);` method using correct credentials, all further request are done as the given user.

### About authentication methods

The phpGitHubApi::AUTH_URL_TOKEN authentication method sends the username and API token in URL parameters. The phpGitHubApi::AUTH_HTTP_* authentication methods send their values to GitHub using HTTP Basic Authentication. phpGitHubApi::AUTH_URL_TOKEN used to be the only available authentication method. To prevent existing applications from changing their behavior in case of an API upgrade, this method is choosen as the default for this API implementation. Note however that GitHub describes this method as deprecated. In most case you should use the phpGitHubApi::AUTH_HTTP_TOKEN instead.

### Deauthentication

If you want to stop new requests from being authenticated, you can use the deAuthenticate method.

    $github->deAuthenticate();

## Users

Searching users, getting user information and managing authenticated user account information.
Wrap [GitHub User API](http://develop.github.com/p/users.html).

### Search for users by username

    $users = $github->getUserApi()->search('ornicar');

Returns an array of users.

### Get information about a user

    $user = $github->getUserApi()->show('ornicar');

Returns an array of information about the user.

### Update user informations

Change user attributes: name, email, blog, company, location. Requires authentication.

    $github->getUserApi()->update('ornicar', array('location' => 'France', 'blog' => 'http://diem-project.org/blog'));

Returns an array of information about the user.

### Get users that a specific user is following

    $users = $github->getUserApi()->getFollowing('ornicar');

Returns an array of followed users.

### Get users following a specific user

    $users = $github->getUserApi()->getFollowers('ornicar');

Returns an array of following users.

### Follow a user

Make the authenticated user follow a user. Requires authentication.

    $github->getUserApi()->follow('symfony');

Returns an array of followed users.

### Unfollow a user

Make the authenticated user unfollow a user. Requires authentication.

    $github->getUserApi()->unFollow('symfony');

Returns an array of followed users.

### Get repos that a specific user is watching

    $users = $github->getUserApi()->getWatchedRepos('ornicar');

Returns an array of watched repos.

### Get the authenticated user emails

    $emails = $github->getUserApi()->getEmails();

Returns an array of the authenticated user emails. Requires authentication.

### Add an email to the authenticated user

    $github->getUserApi()->addEmail('my-email@provider.org');

Returns an array of the authenticated user emails. Requires authentication.

### Remove an email from the authenticated user

    $github->getUserApi()->removeEmail('my-email@provider.org');

Return an array of the authenticated user emails. Requires authentication.

## Issues

Listing issues, searching, editing and closing your projects issues.
Wrap [GitHub Issue API](http://develop.github.com/p/issues.html).

### List issues in a project

    $issues = $github->getIssueApi()->getList('ornicar', 'php-github-api', 'open');

Returns an array of issues.

### Search issues in a project

    $issues = $github->getIssueApi()->search('ornicar', 'php-github-api', 'closed', 'bug');

Returns an array of closed issues matching the "bug" term,.

### Get information about an issue

    $issue = $github->getIssueApi()->show('ornicar', 'php-github-api', 1);

Returns an array of information about the issue.

### Open a new issue

    $github->getIssueApi()->open('ornicar', 'php-github-api', 'The issue title', 'The issue body');

Creates a new issue in the repo "php-github-api" of the user "ornicar".
The issue is assigned to the authenticated user. Requires authentication.
Returns an array of information about the issue.

### Close an issue

    $github->getIssueApi()->close('ornicar', 'php-github-api', 4);

Closes the fourth issue of the repo "php-github-api" of the user "ornicar". Requires authentication.
Returns an array of information about the issue.

### Reopen an issue

    $github->getIssueApi()->reOpen('ornicar', 'php-github-api', 4);

Reopens the fourth issue of the repo "php-github-api" of the user "ornicar". Requires authentication.
Returns an array of information about the issue.

### Update an issue

    $github->getIssueApi()->update('ornicar', 'php-github-api', 4, array('body' => 'The new issue body'));

Updates the fourth issue of the repo "php-github-api" of the user "ornicar". Requires authentication.
Available attributes are title and body.
Returns an array of information about the issue.

### List an issue comments

    $comments = $github->getIssueApi()->getComments('ornicar', 'php-github-api', 4);

List an issue comments by username, repo and issue number.
Returns an array of issues.

### Add a comment on an issue

    $github->getIssueApi()->addComment('ornicar', 'php-github-api', 4, 'My new comment');

Add a comment to the issue by username, repo and issue number.
The comment is assigned to the authenticated user. Requires authentication.

### List project labels

    $labels = $github->getIssueApi()->getLabels('ornicar', 'php-github-api');

List all project labels by username and repo.
Returns an array of project labels.

### Add a label on an issue

    $github->getIssueApi()->addLabel('ornicar', 'php-github-api', 'label name', 4);

Add a label to the issue by username, repo, label name and issue number. Requires authentication.
If the label is not yet in the system, it will be created.
Returns an array of the issue labels.

### Remove a label from an issue

    $github->getIssueApi()->removeLabel('ornicar', 'php-github-api', 'label name', 4);

Remove a label from the issue by username, repo, label name and issue number. Requires authentication.
Returns an array of the issue labels.

### Search issues matching a label

    $github->getIssueApi()->searchLabel('ornicar', 'php-github-api', 'label name')

Returns an array of issues matching the given label.

## Commits

Getting information on specific commits, the diffs they introduce, the files they've changed.
Wrap [GitHub Commit API](http://develop.github.com/p/commits.html).

### List commits in a branch

    $commits = $github->getCommitApi()->getBranchCommits('ornicar', 'php-github-api', 'master');

Returns an array of commits.

### List commits for a file

    $commits = $github->getCommitApi()->getFileCommits('ornicar', 'php-github-api', 'master', 'README');

Returns an array of commits.

### Get a single commit

    $commit = $github->getCommitApi()->getCommit('ornicar', 'php-github-api', '726eac09a3b44411bd86');

Returns a single commit.

## Objects

Getting full versions of specific files and trees in your Git repositories. Wrap [GitHub objects API](http://develop.github.com/p/objects.html).

### List contents of a tree

    $tree = $github->getObjectApi()->showTree('ornicar', 'php-github-api', '691c2ec7fd0b948042047b515886fec40fe76e2b');

Returns an array containing a tree of the repository.

### List all blobs of a tree

    $blobs = $github->getObjectApi()->listBlobs('ornicar', 'php-github-api', '691c2ec7fd0b948042047b515886fec40fe76e2b');

Returns an array containing the tree blobs.

### Show the informations of a blob

    $blob = $github->getObjectApi()->showBlob('ornicar', 'php-github-api', '691c2ec7fd0b948042047b515886fec40fe76e2b', 'CHANGELOG');

Returns array of blob informations.

### Show the raw content of an object

    $rawText = $github->getObjectApi()->getRawData('ornicar', 'php-github-api', 'bd25d1e4ea7eab84b856131e470edbc21b6cd66b');

The last parameter can be either a blob SHA1, a tree SHA1 or a commit SHA1.
Returns the raw text content of the object.

## Repos

Searching repositories, getting repository information and managing repository information for authenticated users.
Wrap [GitHub Repo API](http://develop.github.com/p/repo.html). All methods are described on that page.

### Search repos by keyword

#### Simple search

    $repos = $github->getRepoApi()->search('symfony');

Returns a list of repositories.

#### Advanced search

You can filter the results by language. It takes the same values as the language drop down on [http://github.com/search](http://github).
    $repos = $github->getRepoApi()->search('chess', 'php');

You can specify the page number:
    $repos = $github->getRepoApi()->search('chess' , 'php', 2);

### Get extended information about a repository

    $repo = $github->getRepoApi()->show('ornicar', 'php-github-api')

Returns an array of information about the specified repository.

### Get the repositories of a specific user

    $repos = $github->getRepoApi()->getUserRepos('ornicar');

Returns a list of repositories.

### Get the repositories the authenticated user can push to

    $repos = $github->getRepoApi()->getPushableRepos();

Returns a list of repositories.

### Create a repository

    $repo = $github->getRepoApi()->create('my-new-repo', 'This is the description of a repo', 'http://my-repo-homepage.org', true);

Creates and returns a public repository named my-new-repo.

### Update a repository

    $repo = $github->getRepoApi()->setRepoInfo('username', 'my-new-repo', array('description' => 'some new description'));

The value array also accepts the parameters
 * description
 * homepage
 * has_wiki
 * has_issues
 * has_downloads

Updates and returns the repository named 'my-new-repo' that is owned by 'username'.

### Delete a repository

    $token = $github->getRepoApi()->delete('my-new-repo'); // Get the deletion token
    $github->getRepoApi()->delete('my-new-repo', $token);  // Confirm repository deletion

Deletes the my-new-repo repository.

### Making a repository public or private

    $github->getRepoApi()->setPublic('reponame');
    $github->getRepoApi()->setPrivate('reponame');

Makes the 'reponame' repository public or private and returns the repository.

### Get the deploy keys of a repository

    $keys = $github->getRepoApi()->getDeployKeys('reponame');

Returns a list of the deploy keys for the 'reponame' repository.

### Add a deploy key to a repository

    $keys = $github->getRepoApi()->addDeployKey('reponame', 'key title', $key);

Adds a key with title 'key title' to the 'reponame' repository and returns a list of the deploy keys for the repository.

### Remove a deploy key from a repository

    $keys = $github->getRepoApi()->removeDeployKey('reponame', 12345);

Removes the key with id 12345 from the 'reponame' repository and returns a list of the deploy keys for the repository.

### Get the collaborators for a repository

    $collaborators = $github->getRepoApi()->getRepoCollaborators('reponame');

Returns a list of the collaborators for the 'reponame' repository.

### Add a collaborator to a repository

    $collaborators = $github->getRepoApi->addCollaborator('reponame', 'username');

Adds the 'username' user as collaborator to the 'reponame' repository.

### Remove a collaborator from a repository

    $collaborators = $github->getRepoApi->removeCollaborator('reponame', 'username');

Remove the 'username' collaborator from the 'reponame' repository.

### Watch and unwatch a repository

    $repository = $github->getRepoApi->watch('ornicar', 'php-github-api');
    $repository = $github->getRepoApi->unwatch('ornicar', 'php-github-api');

Watches or unwatches the 'php-github-api' repository owned by 'ornicar' and returns the repository.

### Fork a repository

    $repository = $github->getRepoApi->fork('ornicar', 'php-github-api');

Creates a fork of the 'php-github-api' owned by 'ornicar' and returns the newly created repository.

### Get the tags of a repository

    $tags = $github->getRepoApi()->getRepoTags('ornicar', 'php-github-api');

Returns a list of tags.

### Get the branches of a repository

    $tags = $github->getRepoApi()->getRepoBranches('ornicar', 'php-github-api');

Returns a list of branches.

### Get the watchers of a repository

    $watchers = $github->getRepoApi()->getRepoWatchers('ornicar', 'php-github-api');

Returns list of the users watching the 'php-github-api' owned by 'ornicar'.

### Get the network (forks) of a repository

    $network = $github->getRepoApi()->getRepoNetwork('ornicar', 'php-github-api');

Returns list of the forks of the 'php-github-api' owned by 'ornicar', including the original repository.

### Get the languages for a repository

    $contributors = $github->getRepoApi()->getRepoLanguages('ornicar', 'php-github-api');

Returns a list of languages.

### Get the contributors of a repository

    $contributors = $github->getRepoApi()->getRepoContributors('ornicar', 'php-github-api');

Returns a list of contributors.

To include non GitHub users, add a third parameter to true:

    $contributors = $github->getRepoApi()->getRepoContributors('ornicar', 'php-github-api', true);

## Request any route

The method you need does not exist yet?
You can access any GitHub route by using the "get" and "post" methods.
For example,

    $repo = $github->get('repos/show/ornicar/php-github-api');

Returns an array describing the php-github-api repository.

See all GitHub API routes: [http://develop.github.com/](http://develop.github.com/)

## Customize phpGitHubApi

The library is highly configurable and extensible thanks to dependency injection.

### Configure the request

Wanna change, let's say, the request User Agent?

    $github->getRequest()->setOption('user_agent', 'My new User Agent');

See all request available options in request/phpGitHubApiRequest.php

### Inject a new request instance

If you want to use your own request implementation, inject it to the GitHubApi:

    // create a custom request
    class myGitHubRequest extends phpGitHubApiRequest
    {
      // override things
    }

    // inject your request instance to the API.
    $github->setRequest(new myGitHubRequest());

Your request implementation must extend phpGitHubApiRequest.

### Inject a new API part instance

If you want to use your own implementation of an API, inject it to the GitHubApi.
For example, to replace the user API:

    // create a custom User API
    class myGitHubApiUser extends phpGitHubApiUser
    {
      // overwrite things
    }

    $github->setApi('user', new myGitHubApiUser($github));

## Run test suite

All code is fully unit tested. To run tests on your machine, from a CLI, run

    php /path/to/php-github-api/prove.php

You should see

    test/apiTest.........................................................ok
    test/authenticationTest..............................................ok
    test/commitTest......................................................ok
    test/issueTest.......................................................ok
    test/objectTest......................................................ok
    test/repoTest........................................................ok
    test/userTest........................................................ok
    All tests successful.                                                 
    Files=7, Tests=101                                                    

## Run one test

You can choose to run only one test; usefull when working on a feature.

    php php test/commitTest.php

## Credits

This library borrows ideas, code and tests from [phptwitterbot](http://code.google.com/p/phptwitterbot/).

### Contributors hall of fame

- Thanks to [noloh](http://github.com/noloh) for his contribution on the Object API.
- Thanks to [bshaffer](http://github.com/bshaffer) for his contribution on the Repo API.
- Thanks to [Rolf van de Krol](http://github.com/rolfvandekrol) for his countless contributions.

Thanks to GitHub for the high quality API and documentation.
