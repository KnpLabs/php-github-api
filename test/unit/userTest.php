<?php
require_once dirname(__FILE__).'/../../vendor/lime.php';
require_once dirname(__FILE__).'/../../lib/phpGitHubApi.php';

$t = new lime_test();

$username = 'ornicartest';
$token    = 'fd8144e29b4a85e9487d1cacbcd4e26c';

$api = new phpGitHubApi(true);

$t->comment('Search users');

$users = $api->searchUsers($username);

$t->is(count($users), 1, 'Found one user');

$t->is(array_keys($users), array($username), 'Found '.$username.' user');

$t->comment('Show a user');

$user = $api->showUser($username);

$t->is($user['login'], $username, 'Found infos about '.$username.' user');

$t->comment('Show a non-existing user');

try
{
  $user = $api->showUser('this-user-probably-doesnt-exist');
  $t->fail('Found no infos about this-user-probably-doesnt-exist user');
}
catch(phpGitHubApiRequestException $e)
{
  $t->pass('Found no infos about this-user-probably-doesnt-exist user');
}

$t->comment('Authenticate '.$username);

$api->authenticate($username, $token);

$t->comment('Update user location to Argentina');

$api->updateUser($username, array('location' => 'Argentina'));

$user = $api->showUser($username);

$t->is($user['location'], 'Argentina', 'User new location is Argentina');

$t->comment('Update user location to France');

$api->updateUser($username, array('location' => 'France'));

$user = $api->showUser($username);

$t->is($user['location'], 'France', 'User new location is France');