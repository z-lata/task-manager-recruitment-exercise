<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([__DIR__ . '/config', __DIR__ . '/public', __DIR__ . '/src', __DIR__ . '/tests'])
    ->withRootFiles()
    ->withSymfonyContainerXml(__DIR__ . '/var/cache/dev/App_KernelDevDebugContainer.xml')
    ->withSymfonyContainerPhp(__DIR__ . '/var/cache/dev/App_KernelDevDebugContainer.php')
//    ->withPHPStanConfigs([
//        __DIR__ . '/phpstan.dist.neon',
//    ])
    ->withCache(cacheDirectory: __DIR__ . '/var/build/rector', cacheClass: FileCacheStorage::class)
    ->withParallel(timeoutSeconds: 300, maxNumberOfProcess: 8, jobSize: 50)
    ->withIndent()
    ->withFluentCallNewLine()
    ->withImportNames(removeUnusedImports: true)
    ->withTreatClassesAsFinal()
    ->withComposerBased(twig: true, doctrine: true, phpunit: true, symfony: true)
    ->withAttributesSets(symfony: true, doctrine: true, gedmo: true, phpunit: true)
    ->withPhpSets(php84: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        typeDeclarationDocblocks: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        earlyReturn: true,
        carbon: true,
        rectorPreset: true,
        phpunitCodeQuality: true,
        doctrineCodeQuality: true,
        symfonyCodeQuality: true,
        symfonyConfigs: true,
    )
;
