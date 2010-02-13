<?php

require_once dirname(__FILE__).'/../../vendor/lime.php';
require_once dirname(__FILE__).'/../../lib/phpGitHubApi.php';

$t = new lime_test(2);

$api = new phpGitHubApi();

$t->comment('Test ->listIssues');

$issues = $api->listIssues('ornicar', 'php-github-api', 'closed');

$t->is($issues[0]['state'], 'closed', 'Found closed issues');

$t->comment('Test ->searchIssues');

$issues = $api->searchIssues('ornicar', 'php-github-api', 'closed', 'documentation');

$t->is($issues[0]['state'], 'closed', 'Found closed issues matching "documentation"');