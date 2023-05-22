<?php

use Jasny\PhpdocParser\PhpdocParser;
use Jasny\PhpdocParser\Set\PhpDocumentor;

require 'vendor/autoload.php';

$reflection = new ReflectionClass(\Github\Client::class);
$parser = new PHPDocParser(PhpDocumentor::tags());
$meta = $parser->parse($reflection->getDocComment());

$replacements = '';
foreach ($meta['methods'] as $method) {
    $replacements .= "\"{$method['name']}\" => \Github\\{$method['return_type']}::class,".PHP_EOL;
}

$str = file_get_contents('./.phpstorm.meta.stub');
$str = str_replace('$METHODS$', $replacements, $str);
file_put_contents('.phpstorm.meta.1.php', $str);
