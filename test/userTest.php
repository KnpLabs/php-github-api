<?php
require_once dirname(__FILE__).'/vendor/lime.php';
require_once dirname(__FILE__).'/../lib/phpGitHubApi.php';

$t = new lime_test(16);

$username = 'ornicartest';
$token    = 'fd8144e29b4a85e9487d1cacbcd4e26c';

$github = new phpGitHubApi(true);

$t->comment('Search users');

$users = $github->getUserApi()->search($username);

$t->is(count($users), 1, 'Found one user');

$t->is(array_keys($users), array($username), 'Found '.$username.' user');

$t->is_deeply($github->searchUsers($username), $users, 'Both new and BC syntax work');

$t->comment('Show a user');

$user = $github->getUserApi()->show($username);

$t->is($user['login'], $username, 'Found infos about '.$username.' user');

$t->is_deeply($github->showUser($username), $user, 'Both new and BC syntax work');

$t->comment('Show a non-existing user');

try
{
  $user = $github->getUserApi()->show('this-user-probably-doesnt-exist');
  $t->fail('Found no infos about this-user-probably-doesnt-exist user');
}
catch(phpGitHubApiRequestException $e)
{
  $t->pass('Found no infos about this-user-probably-doesnt-exist user');
}

$t->comment('Get following users');

$users = $github->getUserApi()->getFollowing('ornicar');

$t->ok(count($users), 'Found '.'ornicar'.' following users');

$t->comment('Get follower users');

$users = $github->getUserApi()->getFollowers('ornicar');

$t->ok(count($users), 'Found '.'ornicar'.' followers users');

$t->comment('Authenticate '.$username);

$github->authenticate($username, $token);

$t->comment('Update user location to Argentina');

$github->getUserApi()->update($username, array('location' => 'Argentina'));

$user = $github->getUserApi()->show($username);

$t->is($user['location'], 'Argentina', 'User new location is Argentina');

$t->comment('Update user location to France');

$github->getUserApi()->update($username, array('location' => 'France'));

$user = $github->getUserApi()->show($username);

$t->is($user['location'], 'France', 'User new location is France');

$t->comment('Follow ornicar');

$github->getUserApi()->follow('ornicar');

$t->is(in_array('ornicar', $github->getUserApi()->getFollowing($username)), $username.' follows ornicar');

$t->comment('Unfollow ornicar');

$github->getUserApi()->unfollow('ornicar');

$t->is(!in_array('ornicar', $github->getUserApi()->getFollowing($username)), $username.' does not follow ornicar');

$t->comment('Get watched repos');

$repos = $github->getUserApi()->getWatchedRepos('ornicar');

$t->ok(array_key_exists('homepage', array_pop($repos)), 'Found '.'ornicar'.' watched repos');

$t->comment('Get emails');

$emails = $github->getUserApi()->getEmails();

$t->ok(in_array('ornicar@yopmail.com', $emails), 'Found '.$username.' emails');

$newEmail = 'test@provider.org';
$t->comment('Add '.$newEmail.' email');

$emails = $github->getUserApi()->addEmail($newEmail);

$t->ok(in_array($newEmail, $emails), 'Found the added '.$newEmail.' email');

$t->comment('Remove '.$newEmail.' email');

$emails = $github->getUserApi()->removeEmail($newEmail);

$t->ok(!in_array($newEmail, $emails), 'Not found the removed '.$newEmail.' email');