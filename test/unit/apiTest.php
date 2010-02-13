<?php
require_once dirname(__FILE__).'/../../vendor/lime.php';
require_once dirname(__FILE__).'/../../lib/phpGitHubApi.php';

$t = new lime_test(5);

$t->comment('Test request');

$request = new phpGitHubApiRequest();

$t->isa_ok($request, 'phpGitHubApiRequest', 'Got a phpGitHubApiRequest instance');

$users = $request->get('user/search/diem-project');

$t->is(count($users['users']), 1, 'Found one user');

$t->is(array_keys($users['users']), array('diem-project'), 'Found diem-project user');

$t->comment('Test api');

$api = new phpGitHubApi();

$t->isa_ok($api, 'phpGitHubApi', 'Got a phpGitHubApi instance');

$repo = $api->get('repos/show/ornicar/php-github-api');

$t->is($repo['repository']['name'], 'php-github-api', 'Found information about php-github-api repo');