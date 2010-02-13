<?php

require_once dirname(__FILE__).'/../../vendor/lime.php';
require_once dirname(__FILE__).'/../../lib/phpGitHubApi.php';

$t = new lime_test(3);

$api = new phpGitHubApi(true);

$t->comment('Test ->listIssues');

$issues = $api->listIssues('ornicar', 'php-github-api', 'closed');

$t->is($issues[0]['state'], 'closed', 'Found closed issues');

$t->comment('Test ->searchIssues');

$issues = $api->searchIssues('ornicar', 'php-github-api', 'closed', 'documentation');

$t->is($issues[0]['state'], 'closed', 'Found closed issues matching "documentation"');

$issue = $api->showIssue('ornicar', 'php-github-api', 1);

$t->is($issue['title'], 'Provide documentation', 'Found issue #1');