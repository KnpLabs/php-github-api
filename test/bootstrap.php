<?php

$loader = require_once __DIR__.'/../vendor/.composer/autoload.php';
$loader->add('Github_', __DIR__.'/../lib');
$loader->add('Github_', __DIR__.'/../test');

return $loader;
