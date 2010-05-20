<?php
require_once dirname(__FILE__).'/vendor/lime.php';
require_once dirname(__FILE__).'/../lib/phpGitHubApi.php';

$t = new lime_test(3);

$username = 'ornicartest';
$token    = 'fd8144e29b4a85e9487d1cacbcd4e26c';
$repo     = 'php-github-api';

$api = new phpGitHubApi();

$t->comment('Get user with NO authentication');

$user = $api->getUserApi()->show($username);

$t->ok(!isset($user['plan']), 'User plan is not available');

$t->comment('Authenticate '.$username);

$api->authenticate($username, $token);

$t->comment('Get user with authentication');

$user = $api->getUserApi()->show($username);

$t->ok(isset($user['plan']), 'User plan is available');

$t->comment('Authenticate '.$username.' with bad token');

$api->authenticate($username, 'bad-token');

$t->comment('Get user with bad authentication');

try
{
  $user = $api->getUserApi()->show($username);
  $t->fail('Call with bad authentication throws a phpGitHubApiRequestException');
}
catch(phpGitHubApiRequestException $e)
{
  $t->pass('Call with bad authentication throws a phpGitHubApiRequestException');
}