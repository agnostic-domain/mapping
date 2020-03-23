<?php

return PhpCsFixer\Config::create()
    ->setFinder(PhpCsFixer\Finder::create()->in(['src', 'use-case/src', 'test']))
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'braces' => ['allow_single_line_closure' => true],
        'function_declaration' => ['closure_function_spacing' => 'none']
    ])
    ->setRiskyAllowed(true)
    ->setUsingCache(false);
