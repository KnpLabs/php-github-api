<?php
require_once dirname(__FILE__).'/../../vendor/lime.php';
require_once dirname(__FILE__).'/../../lib/phpGitHubApi.php';

$t = new lime_test(4);

$api = new phpGitHubApi(true);

$t->comment('Test ->searchUsers');

$users = $api->searchUsers('diem-project');

$t->is(count($users), 1, 'Found one user');

$t->is(array_keys($users), array('diem-project'), 'Found diem-project user');

$t->comment('Test ->showUser');

$user = $api->showUser('diem-project');

$t->is($user['login'], 'diem-project', 'Found infos about diem-project user');

$message = 'Found no infos about this-user-probably-doesnt-exist user';
try
{
  $user = $api->showUser('this-user-probably-doesnt-exist');
  $t->fail($message);
}
catch(phpGitHubApiRequestException $e)
{
  $t->pass($message);
}