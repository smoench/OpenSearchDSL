<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromAssignsRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictGetterMethodReturnTypeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests'
    ]);

    // register a single rule
    //$rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

    $rectorConfig->rules([
        TypedPropertyFromAssignsRector::class,
        TypedPropertyFromStrictConstructorRector::class,
        TypedPropertyFromStrictGetterMethodReturnTypeRector::class,
    ]);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_81,
        PHPUnitSetList::PHPUNIT_100,
        SetList::CODE_QUALITY,
    ]);
};
