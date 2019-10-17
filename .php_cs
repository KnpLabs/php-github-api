<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/lib')
    ->in(__DIR__ . '/test')
    ->append([__FILE__])
;

return PhpCsFixer\Config::create()
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'return_assignment' => true,
    ])
;
