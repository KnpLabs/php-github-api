<?php

require_once dirname(__FILE__).'/vendor/lime.php';
require_once dirname(__FILE__).'/../lib/phpGitHubApi.php';

$t = new lime_test(5);

$username = 'ornicar';
$repo     = 'php-github-api';
$branch   = 'master';

$api = new phpGitHubApi(true);

$t->comment('Test ->listBranchCommits');

$commits = $api->getCommitApi()->getBranchCommits($username, $repo, $branch);

$t->is_deeply($api->listBranchCommits($username, $repo, $branch), $commits, 'Both new and BC syntax work');

$firstCommit = array_pop($commits);

$t->ok(isset($firstCommit['message']), 'Found master commits');

$t->comment('Test ->getFileCommits');

$commits = $api->getCommitApi()->getFileCommits($username, $repo, $branch, 'README');

$t->is_deeply($api->listFileCommits($username, $repo, $branch, 'README'), $commits, 'Both new and BC syntax work');

$firstCommit = array_pop($commits);

$t->is($firstCommit['message'], 'first commit', 'Found master README commits');

$t->comment('Test ->getCommit');

$commit = $api->getCommitApi()->getCommit($username, $repo, '726eac09a3b44411bd86');

$t->is($commit['message'], 'first commit', 'Found commit 726eac09a3b44411bd86');
