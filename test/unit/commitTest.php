<?php

require_once dirname(__FILE__).'/../../vendor/lime.php';
require_once dirname(__FILE__).'/../../lib/phpGitHubApi.php';

$t = new lime_test(2);

$api = new phpGitHubApi(true);

$t->comment('Test ->listBranchCommits');

$commits = $api->listBranchCommits('ornicar', 'php-github-api', 'master');

$firstCommit = array_pop($commits);

$t->is($firstCommit['message'], 'first commit', 'Found master commits');

$commits = $api->listFileCommits('ornicar', 'php-github-api', 'master', 'README');

$firstCommit = array_pop($commits);

$t->is($firstCommit['message'], 'first commit', 'Found master README commits');