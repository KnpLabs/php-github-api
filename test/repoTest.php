<?php
require_once dirname(__FILE__).'/vendor/lime.php';
require_once dirname(__FILE__).'/../lib/phpGitHubApi.php';

$t = new lime_test(45);

$username = 'ornicartest';
$token    = 'fd8144e29b4a85e9487d1cacbcd4e26c';

$github = new phpGitHubApi(true);

// search method
$t->comment('Search repos');
$repos = $github->getRepoApi()->search('php github api');
$t->ok(count($repos) > 0, 'Found '.count($repos).' repos');
$t->ok(isset($repos[0]['name']), 'First repo name: '.$repos[0]['name']);

$t->comment('Search repos, specify language');
$repos = $github->getRepoApi()->search('github', 'JavaScript');
$t->is($repos[0]['language'], 'JavaScript', 'First repo language is Javascript');
$repos = $github->getRepoApi()->search('github', 'php');
$t->is($repos[0]['language'], 'PHP', 'First repo language is Php');

$firstPageRepo = $repos[0]['name'];

$t->comment('Search repos, specify language and start page');
$repos = $github->getRepoApi()->search('github', 'php', 2);
$t->isnt($repos[0]['name'], $firstPageRepo);
$repos = $github->getRepoApi()->search('github', 'JavaScript');
$t->is($repos[0]['language'], 'JavaScript', 'First repo language is Javascript');

// getUserRepos method
$t->comment('Search repos, specify user');
$repos = $github->getRepoApi()->getUserRepos('ornicar');
$t->ok(count($repos) > 20, 'Found '.count($repos).' repos');
$t->ok(isset($repos[0]['name']), 'First repo name: '.$repos[0]['name']);

// show method
$t->comment('Getting info on specific repository');
$repo = $github->getRepoApi()->show('ornicar', 'php-github-api');
$t->is($repo['name'], 'php-github-api', 'Found repo: '.$repo['name']);

// getRepoCollaborators method
$t->comment('Finding the collaborators on a specific repository');
$collaborators = $github->getRepoApi()->getRepoCollaborators('ornicar', 'php-github-api');
$t->ok(count($collaborators) > 0, 'Found '.count($collaborators).' collaborators');

// authenticate before repository management tests
$t->comment('Authentice to be able to test repository management');
$github->authenticate($username, $token, phpGitHubApi::AUTH_HTTP_TOKEN);

// getPushableRepos method
$t->comment('Find the repositories, the authenticated user can push to');
$repos = $github->getRepoApi()->getPushableRepos();
$t->ok(count($repos) > 0, 'Found '.count($repos).' repos');
$t->ok(isset($repos[0]['name']), 'First repo name: '.$repos[0]['name']);

// create method
$t->comment('Create a new repository');
$info = $github->getRepoApi()->create('NewRepo', 'new repo description', 'http://github.com', true);
$t->is($info['name'], 'NewRepo', 'Repo created with name "NewRepo"');
$t->is($info['description'], 'new repo description', 'Repo created with description "new repo description"');
$t->is($info['homepage'], 'http://github.com', 'Repo created with homepage "http://github.com"');
$t->is($info['private'], false, 'Repo created is public');

// setRepoInfo method
$t->comment('Changes an attribute of a repository');
$info = $github->getRepoApi()->setRepoInfo('ornicartest', 'NewRepo', array('description' => 'changed repo description'));
$t->is($info['description'], 'changed repo description', 'Repo changed to description "changed repo description"');

// getDeployKeys method empty
$t->comment('List, add and delete deploy keys on a repository');
$keys = $github->getRepoApi()->getDeployKeys('NewRepo');
$t->ok(count($keys) == 0, 'No deploy keys setup on NewRepo');

// addDeployKey method
$key = "ssh-rsa AAAAB3NzaC1yc2EAAAABIwAAAQEA0yy9pZITu7sCNQdGHggW5hyw734yj5k82kJnLnoA3qLC+t5Q6UyxkWQNeybjv6MQnpV3B+cVr/1/d9G98xG3fOfHU/tMjV5sad+cZTKsyGapL8ut+L2B80uFkKy/zV3gFZZEbDeK4CgzSMgamtMaYKmSyF62/JUI+6lS3LzlzQLbbP+Zkdda5jz6Sm2Fn6nsKm5K6ZWAatUOV9kW/KeutKYLBMyQT3DsZLcrMXtI3rkmfo+p1Nvkjqlq+PLcWU3qF0vssfjdCAuDB1HKeLc4PHNBleupjrOZKAvLHueVv5XQt1fofCDsprBad21Q7uHzWJpEdmadIz+UE+6tqyfqdQ==";
$keys = $github->getRepoApi()->addDeployKey('newRepo', 'newKey', $key);
$t->is($keys[0]['title'], 'newKey', 'Key added with title "newKey"');
$t->is($keys[0]['key'], $key, 'Key added with correct key');
$t->ok(isset($keys[0]['id']), 'Key got assigned id: ' . $keys[0]['id']);
$key_id = $keys[0]['id'];

// getDeployKeys method
$keys = $github->getRepoApi()->getDeployKeys('NewRepo');
$t->ok(count($keys) == 1, 'Found 1 deploy keys setup on NewRepo');

// removeDeployKeys method
$keys = $github->getRepoApi()->removeDeployKey('NewRepo', $key_id);
$t->ok(count($keys) == 0, 'Deploy key removed from NewRepo');

// getRepoCollaborators method
$t->comment('List, add and delete collaborators on a repository');
$collaborators = $github->getRepoApi()->getRepoCollaborators('ornicartest', 'NewRepo');
$t->ok(count($collaborators) == 1, 'Found 1 collaborator on NewRepo');
$t->is($collaborators[0], 'ornicartest', 'ornicartest is the only collaborator');

// addRepoCollaborator method
$collaborators = $github->getRepoApi()->addRepoCollaborator('NewRepo', 'rolfvandekrol');
$t->ok(count($collaborators) == 2, 'Added 1 collaborator on NewRepo');
$t->is($collaborators[1], 'rolfvandekrol', 'Added rolfvandekrol as new collaborator');

// removeRepoCollaborator method
$collaborators = $github->getRepoApi()->removeRepoCollaborator('NewRepo', 'rolfvandekrol');
$t->ok(count($collaborators) == 1, 'Removed 1 collaborator from NewRepo');
$t->is($collaborators[0], 'ornicartest', 'ornicartest is the only collaborator');

// delete method
$t->comment('Delete a repository');
$token = $github->getRepoApi()->delete('NewRepo');
$t->ok(is_string($token), 'String delete_token is returned');
$response = $github->getRepoApi()->delete('NewRepo', $token);
$t->is($response['status'], 'deleted', 'Repo is deleted');

// watch method
$t->comment('Watch a repository');
$repository = $github->getRepoApi()->watch('ornicar', 'php-git-repo');
$t->is($repository['name'], 'php-git-repo', 'Watching php-git-repo');

// fork method
$t->comment('Fork a repository');
$repository = $github->getRepoApi()->fork('ornicar', 'php-git-repo');
$t->is($repository['name'], 'php-git-repo', 'Forked php-git-repo');
$repository = $github->getRepoApi()->delete('php-git-repo', null, true);
$t->is($response['status'], 'deleted', 'Fork is deleted');

// unwatch method
$t->comment('Unwatch a repository');
$repository = $github->getRepoApi()->unwatch('ornicar', 'php-git-repo');
$t->is($repository['name'], 'php-git-repo', 'Unwatching php-git-repo');

// deauthenticate back to anonymous state
$t->comment('Deauthenticating');
$github->deAuthenticate();

// getRepoContributors method
$t->comment('Get contributors for a repository');
$contributors = $github->getRepoApi()->getRepoContributors('ornicar', 'php-github-api');
$t->ok(count($contributors) > 2, 'Found '.count($contributors).' contributors');
$t->is($contributors[0]['login'], 'ornicar', 'First contributor is ornicar');

// getRepoTags method
$t->comment('Get tags for a repository');
$tags = $github->getRepoApi()->getRepoTags('ornicar', 'php-github-api');
$t->ok(count($tags) > 5, 'Found '.count($tags).' tags');
$tagNames = array_keys($tags);
$t->ok($tagNames[0], 'First tag name: '.$tagNames[0]);

// getRepoBranches method
$t->comment('Get branches for a repository');
$branches = $github->getRepoApi()->getRepoBranches('ornicar', 'php-github-api');
$t->ok(count($branches) > 0, 'Found '.count($branches).' branch(es)');
$t->ok(isset($branches['master']), 'Found master branch: '.$branches['master']);

// getRepoNetwork method
$t->comment('Get forks for a repository');
$network = $github->getRepoApi()->getRepoNetwork('ornicar', 'php-github-api');
$t->ok(count($network) > 0, 'Found '.count($network).' fork(s)');
$t->is($network[0]['owner'], 'ornicar', 'First fork is original from ornicar');

// getRepoLanguages method
$t->comment('Get languages for a repository');
$languages = $github->getRepoApi()->getRepoLanguages('ornicar', 'php-github-api');
$t->ok(count($languages) > 0, 'Found '.count($languages).' language(s)');
$languageNames = array_keys($languages);
$t->is($languageNames[0], 'PHP', 'First languages is PHP');

