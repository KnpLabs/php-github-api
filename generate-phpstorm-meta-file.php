<?php

use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\ConstExprParser;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use PHPStan\PhpDocParser\Parser\TypeParser;

require 'vendor/autoload.php';

$reflection = new ReflectionClass(\Github\Client::class);

$lexer = new Lexer();
$constExprParser = new ConstExprParser();
$typeParser = new TypeParser($constExprParser);
$phpDocParser = new PhpDocParser($typeParser, $constExprParser);

$tokens = new TokenIterator($lexer->tokenize($reflection->getDocComment()));
$phpDocNode = $phpDocParser->parse($tokens);

$replacements = '';
foreach ($phpDocNode->getTagsByName('@method') as $node) {
    $replacements .= "\"{$node->value->methodName}\" => \Github\\{$node->value->returnType->name}::class,".PHP_EOL;
}

$str = file_get_contents('./.phpstorm.meta.stub');
$str = str_replace('$METHODS$', $replacements, $str);
file_put_contents('.phpstorm.meta.php', $str);
