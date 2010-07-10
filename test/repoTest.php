<?php
require_once dirname(__FILE__).'/vendor/lime.php';
require_once dirname(__FILE__).'/../lib/phpGitHubApi.php';

$t = new lime_test();

$username = 'ornicartest';
$token    = 'fd8144e29b4a85e9487d1cacbcd4e26c';

$github = new phpGitHubApi(true);

$t->comment('Search repos');

$repos = $github->getRepoApi()->search('php github api');

$t->ok(count($repos) > 0, 'Found '.count($repos).' repos');

$t->ok(isset($repos[0]['name']), 'First repo name: '.$repos[0]['name']);

$repo = $github->getRepoApi()->show('ornicar', 'php-github-api');

$t->is($repo['name'], 'php-github-api', 'Found repo: '.$repo['name']);

$t->comment('Search repos, specify language');

$repos = $github->getRepoApi()->search('github', 'JavaScript');

$t->is($repos[0]['language'], 'JavaScript', 'First repo language is Javascript');

$repos = $github->getRepoApi()->search('github', 'php');

$t->is($repos[0]['language'], 'PHP', 'First repo language is Php');
$firstPageRepo = $repos[0]['name'];

$t->comment ('Search repos, specify language and start page');

$repos = $github->getRepoApi()->search('github', 'php', 2);
$t->isnt($repos[0]['name'], $firstPageRepo);

$repos = $github->getRepoApi()->search('github', 'JavaScript');

$t->is($repos[0]['language'], 'JavaScript', 'First repo language is Javascript');

$repo = $github->getRepoApi()->show('ornicar', 'php-github-api');

$t->is($repo['name'], 'php-github-api', 'Found repo: '.$repo['name']);

$repos = $github->getRepoApi()->getUserRepos('ornicar');

$t->ok(count($repos) > 20, 'Found '.count($repos).' repos');

$t->ok(isset($repos[0]['name']), 'First repo name: '.$repos[0]['name']);

$contributors = $github->getRepoApi()->getRepoContributors('ornicar', 'php-github-api');
$t->ok(count($contributors) > 2, 'Found '.count($contributors).' contributors');
$t->is($contributors[0]['login'], 'ornicar', 'First contributor is ornicar');

$contributors = $github->getRepoApi()->getRepoContributors('ornicar', 'php-github-api', true);
$t->ok(count($contributors) > 2, 'Found '.count($contributors).' contributors');
$t->is($contributors[0]['login'], 'ornicar', 'First contributor is ornicar');

$tags = $github->getRepoApi()->getRepoTags('ornicar', 'php-github-api');

$t->ok(count($tags) > 5, 'Found '.count($tags).' tags');

$tagNames = array_keys($tags);

$t->ok($tagNames[0], 'First tag name: '.$tagNames[0]);

$branches = $github->getRepoApi()->getRepoBranches('ornicar', 'php-github-api');

$t->ok(count($branches) > 0, 'Found '.count($branches).' branch(es)');

$t->ok(isset($branches['master']), 'Found master branch: '.$branches['master']);

$github->authenticate($username, $token);

$info = $github->getRepoApi()->create('NewRepo', 'new repo description', 'http://github.com', true);

$t->is($info['name'], 'NewRepo', 'Repo created with name "NewRepo"');

$t->is($info['description'], 'new repo description', 'Repo created with description "new repo description"');

$t->is($info['homepage'], 'http://github.com', 'Repo created with homepage "http://github.com"');

$t->is($info['private'], false, 'Repo created is public');

$token = $github->getRepoApi()->delete('NewRepo');

$t->ok(is_string($token), 'String delete_token is returned');

$response = $github->getRepoApi()->delete('NewRepo', $token);

$t->is($response['status'], 'deleted', 'Repo is deleted');
