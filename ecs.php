<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPaths([__DIR__ . '/config', __DIR__ . '/public', __DIR__ . '/src', __DIR__ . '/tests'])
    ->withRootFiles()
    ->withCache(directory: __DIR__ . '/var/build/ecs', namespace: getcwd())
    ->withParallel(timeoutSeconds: 300, maxNumberOfProcess: 8, jobSize: 50)
//    ->withSpacing(
//        indentation: Option::INDENTATION_SPACES,
//        lineEnding: PHP_EOL
//    )
    ->withEditorConfig()
    ->withPreparedSets(psr12: true, common: true, symplify: true, strict: true, cleanCode: true)
    ->withPhpCsFixerSets(doctrineAnnotation: true, phpCsFixer: true, symfony: true)
    ->withRules([NoWhitespaceBeforeCommaInArrayFixer::class, WhitespaceAfterCommaInArrayFixer::class])
    ->withConfiguredRule(ConcatSpaceFixer::class, [
        'spacing' => 'one',
    ])
    ->withConfiguredRule(MethodArgumentSpaceFixer::class, [
        'after_heredoc' => true,
        'attribute_placement' => 'standalone',
        'keep_multiple_spaces_after_comma' => false,
        'on_multiline' => 'ensure_fully_multiline',
    ])
    ->withConfiguredRule(TrailingCommaInMultilineFixer::class, [
        'after_heredoc' => true,
        'elements' => ['arguments', 'array_destructuring', 'arrays', 'match', 'parameters'],
    ])
    ->withConfiguredRule(BinaryOperatorSpacesFixer::class, [
        'default' => 'single_space',
    ])
;
