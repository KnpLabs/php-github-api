## Instanciate a new API

    $api = new phpGitHubApi();

### Authenticate a user

This step is facultative, as most of GitHub services do not require authentication.

    $api->authenticate('ornicar', 'my-token');

## Users

### Search for users by username

    $users = $api->searchUsers('ornicar');

Returns an array of users as described in [http://develop.github.com/p/users.html#searching_for_users](http://develop.github.com/p/users.html#searching_for_users)

### Get informations about a user

    $user = $api->showUser('ornicar');

Returns an array of informations about the user as described in [http://develop.github.com/p/users.html#getting_user_information](http://develop.github.com/p/users.html#getting_user_information)

## Issues

### List issues in a project

    $issues = $api->listIssues('ornicar', 'php-github-api', 'open');

Returns an array of issues as described in [http://develop.github.com/p/issues.html#list_a_projects_issues](http://develop.github.com/p/issues.html#list_a_projects_issues)

### Search issues in a project

    $issues = $api->searchIssues('ornicar', 'php-github-api', 'closed', 'bug');

Returns an array of closed issues matching the "bug" term, as described in [http://develop.github.com/p/issues.html#search_issues](http://develop.github.com/p/issues.html#search_issues)

### Get informations about an issue

    $users = $api->showIssue('ornicar', 'php-github-api', 1);

Returns an array of informations about the issue as described in [http://develop.github.com/p/issues.html#view_an_issue](http://develop.github.com/p/issues.html#view_an_issue)

## Commits

### List commits in a branch

    $commits = $api->listCommits('ornicar', 'php-github-api', 'master');

Returns an array of commits as described in [http://develop.github.com/p/commits.html#listing_commits_on_a_branch](http://develop.github.com/p/commits.html#listing_commits_on_a_branch)

### List commits for a file

    $commits = $api->listCommits('ornicar', 'php-github-api', 'master', 'README');

Returns an array of commits as described in [http://develop.github.com/p/commits.html#listing_commits_for_a_file](http://develop.github.com/p/commits.html#listing_commits_for_a_file)

## Request any route

You can access any GitHub route by using the "get" and "post" methods.

    $repo = $api->get('repos/show/ornicar/php-github-api');

Returns an array describing the php-github-api repository.

See all GitHub API routes: [http://develop.github.com/](http://develop.github.com/)

## Run test suite

All code is fully unit tested. To run tests on your server, from a CLI, run

    php /path/to/php-github-api/test/bin/prove.php

## Credits

This library borrows ideas, code and tests from [phptwitterbot](http://code.google.com/p/phptwitterbot/).