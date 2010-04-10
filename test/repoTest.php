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

$repos = $github->getRepoApi()->getUserRepos('ornicar');

$t->ok(count($repos) > 20, 'Found '.count($repos).' repos');

$t->ok(isset($repos[0]['name']), 'First repo name: '.$repos[0]['name']);

$tags = $github->getRepoApi()->getRepoTags('ornicar', 'php-github-api');

$t->ok(count($tags) > 5, 'Found '.count($tags).' tags');

$tagNames = array_keys($tags);

$t->ok($tagNames[0], 'First tag name: '.$tagNames[0]);

$branches = $github->getRepoApi()->getRepoBranches('ornicar', 'php-github-api');

$t->ok(count($branches) > 0, 'Found '.count($branches).' branch(es)');

$t->ok(isset($branches['master']), 'Found master branch: '.$branches['master']);