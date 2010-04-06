<?php
require_once dirname(__FILE__).'/../../vendor/lime.php';
require_once dirname(__FILE__).'/../../lib/phpGitHubApi.php';

$t = new lime_test(3);

$api = new phpGitHubApi(true);

$t->comment('Test ->listObjectTree');

$tree = $api->listObjectTree('ornicar', 'php-github-api', '691c2ec7fd0b948042047b515886fec40fe76e2b');
$firstFile = array_pop($tree);
$t->ok($firstFile['sha'] != null, 'Tree returned with SHA listings');
$blob = $api->showObjectBlob('ornicar', 'php-github-api', '691c2ec7fd0b948042047b515886fec40fe76e2b', 'CHANGELOG');
print_r($blob);
$t->is($blob['name'], 'CHANGELOG', 'Returned CHANGELOG blob');
$blobs = $api->listObjectBlobs('ornicar', 'php-github-api', '691c2ec7fd0b948042047b515886fec40fe76e2b');
$t->ok(count($blobs) > 0, 'Returned array of blobs');