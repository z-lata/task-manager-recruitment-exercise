<?php

declare(strict_types=1);

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

$finder = new Finder()
    ->in(__DIR__)
    ->exclude('var')
;

return new Config()
    ->setRules([
        '@Symfony' => true,
    ])
    ->setFinder($finder)
;
