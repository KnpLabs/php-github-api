<?php
require_once dirname(__FILE__).'/../../vendor/lime.php';
require_once dirname(__FILE__).'/../../lib/phpGitHubApi.php';

$t = new lime_test();

$request = new phpGitHubApiRequest();

$t->isa_ok($request, 'phpGitHubApiRequest', 'Got a phpGitHubApiRequest instance');

$users = $request->get('user/search/diem-project');

$t->is(count($users['users']), 1, 'Found one user');

$t->is(array_keys($users['users']), array('diem-project'), 'Found diem-project user');

$api = new phpGitHubApi();

$t->isa_ok($api, 'phpGitHubApi', 'Got a phpGitHubApi instance');

$users2 = $api->searchUsers('diem-project');

$t->is_deeply($users2, $users['users'], 'Found user diem-project');

$user = $api->showUser('diem-project');

$t->is($user['login'], 'diem-project', 'Found infos about diem-project user');