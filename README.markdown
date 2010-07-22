# PHP GitHub API

A simple, Object Oriented wrapper for GitHub API written with PHP5.

Uses [GitHub API v2](http://develop.github.com/).

Requires [php curl](http://php.net/manual/en/book.curl.php).

If the method you need does not exist yet, dont hesitate to request it with an [issue](http://github.com/ornicar/php-github-api/issues)!

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

Searching users, getting user information and managing authenticated user account information.
Wrap [GitHub User API](http://develop.github.com/p/users.html).

### Search for users by username

    $users = $github->getUserApi()->search('ornicar');

Returns an array of users as described in [http://develop.github.com/p/users.html#searching_for_users](http://develop.github.com/p/users.html#searching_for_users)

### Get information about a user

    $user = $github->getUserApi()->show('ornicar');

Returns an array of information about the user as described in [http://develop.github.com/p/users.html#getting_user_information](http://develop.github.com/p/users.html#getting_user_information)

### Update user informations

Change user attributes: name, email, blog, company, location. Requires authentication.

    $github->getUserApi()->update('ornicar', array('location' => 'France', 'blog' => 'http://diem-project.org/blog'));

Returns an array of information about the user as described in [http://develop.github.com/p/users.html#authenticated_user_management](http://develop.github.com/p/users.html#authenticated_user_management)

### Get users that a specific user is following

    $users = $github->getUserApi()->getFollowing('ornicar');

Returns an array of followed users as described in [http://develop.github.com/p/users.html#following_network](http://develop.github.com/p/users.html#following_network)

### Get users following a specific user

    $users = $github->getUserApi()->getFollowers('ornicar');

Returns an array of following users as described in [http://develop.github.com/p/users.html#following_network](http://develop.github.com/p/users.html#following_network)

### Follow a user

Make the authenticated user follow a user. Requires authentication.

    $github->getUserApi()->follow('symfony');

Returns an array of followed users as described in [http://develop.github.com/p/users.html#following_network](http://develop.github.com/p/users.html#following_network)

### Unfollow a user

Make the authenticated user unfollow a user. Requires authentication.

    $github->getUserApi()->unFollow('symfony');

Returns an array of followed users as described in [http://develop.github.com/p/users.html#following_network](http://develop.github.com/p/users.html#following_network)

### Get repos that a specific user is watching

    $users = $github->getUserApi()->getWatchedRepos('ornicar');

Returns an array of watched repos as described in [http://develop.github.com/p/users.html#watched_repos](http://develop.github.com/p/users.html#watched_repos)

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

Returns an array of issues as described in [http://develop.github.com/p/issues.html#list_a_projects_issues](http://develop.github.com/p/issues.html#list_a_projects_issues)

### Search issues in a project

    $issues = $github->getIssueApi()->search('ornicar', 'php-github-api', 'closed', 'bug');

Returns an array of closed issues matching the "bug" term, as described in [http://develop.github.com/p/issues.html#search_issues](http://develop.github.com/p/issues.html#search_issues)

### Get information about an issue

    $issue = $github->getIssueApi()->show('ornicar', 'php-github-api', 1);

Returns an array of information about the issue as described in [http://develop.github.com/p/issues.html#view_an_issue](http://develop.github.com/p/issues.html#view_an_issue)

### Open a new issue

    $github->getIssueApi()->open('ornicar', 'php-github-api', 'The issue title', 'The issue body');

Creates a new issue in the repo "php-github-api" of the user "ornicar".
The issue is assigned to the authenticated user. Requires authentication.
Returns an array of information about the issue as described in [http://develop.github.com/p/issues.html#view_an_issue](http://develop.github.com/p/issues.html#view_an_issue)

### Close an issue

    $github->getIssueApi()->close('ornicar', 'php-github-api', 4);

Closes the fourth issue of the repo "php-github-api" of the user "ornicar". Requires authentication.
Returns an array of information about the issue as described in [http://develop.github.com/p/issues.html#view_an_issue](http://develop.github.com/p/issues.html#view_an_issue)

### Reopen an issue

    $github->getIssueApi()->reOpen('ornicar', 'php-github-api', 4);

Reopens the fourth issue of the repo "php-github-api" of the user "ornicar". Requires authentication.
Returns an array of information about the issue as described in [http://develop.github.com/p/issues.html#view_an_issue](http://develop.github.com/p/issues.html#view_an_issue)

### Update an issue

    $github->getIssueApi()->update('ornicar', 'php-github-api', 4, array('body' => 'The new issue body'));

Updates the fourth issue of the repo "php-github-api" of the user "ornicar". Requires authentication.
Available attributes are title and body.
Returns an array of information about the issue as described in [http://develop.github.com/p/issues.html#view_an_issue](http://develop.github.com/p/issues.html#view_an_issue)

### List an issue comments

    $comments = $github->getIssueApi()->getComments('ornicar', 'php-github-api', 4);

List an issue comments by username, repo and issue number.
Returns an array of issues as described in [http://develop.github.com/p/issues.html#list_an_issues_comments](http://develop.github.com/p/issues.html#list_an_issues_comments)

### Add a comment on an issue

    $github->getIssueApi()->addComment('ornicar', 'php-github-api', 4, 'My new comment');

Add a comment to the issue by username, repo and issue number.
The comment is assigned to the authenticated user. Requires authentication.

### List project labels

    $labels = $github->getIssueApi()->getLabels('ornicar', 'php-github-api');

List all project labels by username and repo.
Returns an array of project labels as described in [http://develop.github.com/p/issues.html#listing_labels](http://develop.github.com/p/issues.html#listing_labels)

### Add a label on an issue

    $github->getIssueApi()->addLabel('ornicar', 'php-github-api', 'label name', 4);

Add a label to the issue by username, repo, label name and issue number. Requires authentication.
If the label is not yet in the system, it will be created.
Returns an array of the issue labels as described in [http://develop.github.com/p/issues.html#add_and_remove_labels](http://develop.github.com/p/issues.html#add_and_remove_labels)

### Remove a label from an issue

    $github->getIssueApi()->removeLabel('ornicar', 'php-github-api', 'label name', 4);

Remove a label from the issue by username, repo, label name and issue number. Requires authentication.
Returns an array of the issue labels as described in [http://develop.github.com/p/issues.html#add_and_remove_labels](http://develop.github.com/p/issues.html#add_and_remove_labels)

### Search issues matching a label

    $github->getIssueApi()->searchLabel('ornicar', 'php-github-api', 'label name')

Returns an array of issues matching the given label.

## Commits

Getting information on specific commits, the diffs they introduce, the files they've changed.
Wrap [GitHub Commit API](http://develop.github.com/p/commits.html).

### List commits in a branch

    $commits = $github->getCommitApi()->getBranchCommits('ornicar', 'php-github-api', 'master');

Returns an array of commits as described in [http://develop.github.com/p/commits.html#listing_commits_on_a_branch](http://develop.github.com/p/commits.html#listing_commits_on_a_branch)

### List commits for a file

    $commits = $github->getCommitApi()->getFileCommits('ornicar', 'php-github-api', 'master', 'README');

Returns an array of commits as described in [http://develop.github.com/p/commits.html#listing_commits_for_a_file](http://develop.github.com/p/commits.html#listing_commits_for_a_file)

### Get a single commit

    $commit = $github->getCommitApi()->getCommit('ornicar', 'php-github-api', '726eac09a3b44411bd86');

Returns a single commit as described in [http://develop.github.com/p/commits.html#showing_a_specific_commit](http://develop.github.com/p/commits.html#showing_a_specific_commit)

## Objects

Getting full versions of specific files and trees in your Git repositories. Wrap [GitHub objects API](http://develop.github.com/p/objects.html).

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

## Repos

Searching repositories, getting repository information and managing repository information for authenticated users.
Wrap [GitHub Repo API](http://develop.github.com/p/repo.html).

### Search repos by keyword

#### Simple search

    $repos = $github->getRepoApi()->search('symfony');

Returns a list of repositories as described in [http://develop.github.com/p/repo.html#searching_repositories](http://develop.github.com/p/repo.html#searching_repositories)

#### Advanced search

You can filter the results by language. It takes the same values as the language drop down on [http://github.com/search](http://github).
    $repos = $github->getRepoApi()->search('chess', 'php');

You can specify the page number:
    $repos = $github->getRepoApi()->search('chess' , 'php', 2);

### Get extended information about a repository

    $repo = $github->getRepoApi()->show('ornicar', 'php-github-api')

Returns an array of information about the specified repository as described in [http://develop.github.com/p/repo.html#show_repo_info](http://develop.github.com/p/repo.html#show_repo_info)

### Get the repositories of a specific user

    $repos = $github->getRepoApi()->getUserRepos('ornicar');

Returns a list of repositories as described in [http://develop.github.com/p/repo.html#list_all_repositories](http://develop.github.com/p/repo.html#list_all_repositories)

### Get the tags of a repository

    $tags = $github->getRepoApi()->getRepoTags('ornicar', 'php-github-api');

Returns a list of tags as described in [http://develop.github.com/p/repo.html#repository_refs](http://develop.github.com/p/repo.html#repository_refs)

### Get the contributors of a repository

    $contributors = $github->getRepoApi()->getRepoContributors('ornicar', 'php-github-api');

Returns a list of contributors as described in [http://develop.github.com/p/repo.html](http://develop.github.com/p/repo.html)

To include non GitHub users, add a third parameter to true:

    $contributors = $github->getRepoApi()->getRepoContributors('ornicar', 'php-github-api', true);

### Get the branches of a repository

    $tags = $github->getRepoApi()->getRepoBranches('ornicar', 'php-github-api');

Returns a list of branches as described in [http://develop.github.com/p/repo.html#repository_refs](http://develop.github.com/p/repo.html#repository_refs)

### Create a repository

    $repo = $github->getRepoApi()->create('my-new-repo', 'This is the description of a repo', 'http://my-repo-homepage.org', true);

Creates and returns a public repository named my-new-repo as described in [http://develop.github.com/p/repo.html](http://develop.github.com/p/repo.html) 

### Delete a repository

    $token = $github->getRepoApi()->delete('my-new-repo'); // Get the deletion token
    $github->getRepoApi()->delete('my-new-repo', $token);  // Confirm repository deletion

Deletes the my-new-repo repository as described in [http://develop.github.com/p/repo.html](http://develop.github.com/p/repo.html) 

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
      // override things
    }

    $github->setApi('user', new myGitHubApiUser());

## Run test suite

All code is fully unit tested. To run tests on your server, from a CLI, run

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
     Files=7, Tests=77

## Run one test

You can run only one test ; usefull when working on a feature.

    php php test/commitTest.php

## Credits

This library borrows ideas, code and tests from [phptwitterbot](http://code.google.com/p/phptwitterbot/).

Thanks to [noloh](http://github.com/noloh) for his contribution on the Object API.
Thanks to [bshaffer](http://github.com/bshaffer) for his contribution on the Repo API.

Thanks to GitHub for the high quality API and documentation.
