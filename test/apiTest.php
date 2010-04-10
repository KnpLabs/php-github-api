<?php
require_once dirname(__FILE__).'/vendor/lime.php';
require_once dirname(__FILE__).'/../lib/phpGitHubApi.php';
require_once dirname(__FILE__).'/../lib/request/phpGitHubApiRequest.php';

$t = new lime_test(6);

$t->comment('Low level request');

$request = new phpGitHubApiRequest();

$t->isa_ok($request, 'phpGitHubApiRequest', 'Got a phpGitHubApiRequest instance');

$users = $request->get('user/search/diem-project');

$t->is(count($users['users']), 1, 'Found one user');

$t->is(array_keys($users['users']), array('diem-project'), 'Found diem-project user');

$t->comment('Low level API');

$github = new phpGitHubApi();

$t->isa_ok($github, 'phpGitHubApi', 'Got a phpGitHubApi instance');

$repo = $github->get('repos/show/ornicar/php-github-api');

$t->is($repo['repository']['name'], 'php-github-api', 'Found information about php-github-api repo');

try
{
  $github->get('non-existing-url/for-sure');
  $t->fail('Call to non-existing-url/for-sure throws a phpGitHubApiRequestException');
}
catch(phpGitHubApiRequestException $e)
{
  $t->pass('Call to non-existing-url/for-sure throws a phpGitHubApiRequestException');
}