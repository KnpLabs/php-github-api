<?php
require_once dirname(__FILE__).'/../../vendor/lime.php';
require_once dirname(__FILE__).'/../../lib/phpGitHubApi.php';

$t = new lime_test(6);

$username = 'ornicar';
$repo     = 'php-github-api';
$treeSha  = '691c2ec7fd0b948042047b515886fec40fe76e2b';

$github = new phpGitHubApi(true);

$t->comment('Show tree');

$tree = $github->getObjectApi()->showTree($username, $repo, $treeSha);

$t->is_deeply($github->listObjectTree($username, $repo, $treeSha), $tree, 'Both new and BC syntax work');

$firstFile = array_pop($tree);
$t->is($firstFile['sha'], '5ac35496a1cbb2a914ff4325e7d6e8cae61f90b9', 'Tree returned with SHA listings');

$t->comment('Show blob');

$blob = $github->getObjectApi()->showBlob($username, $repo, $treeSha, 'CHANGELOG');
$t->is($blob['name'], 'CHANGELOG', 'Returned CHANGELOG blob');

$t->is_deeply($github->showObjectBlob($username, $repo, $treeSha, 'CHANGELOG'), $blob, 'Both new and BC syntax work');

$t->comment('List blobs');

$blobs = $github->getObjectApi()->listBlobs($username, $repo, $treeSha);
$t->ok(count($blobs) > 0, 'Returned array of blobs');

$t->is_deeply($github->listObjectBlobs($username, $repo, $treeSha), $blobs, 'Both new and BC syntax work');