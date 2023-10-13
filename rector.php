<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests'
    ]);

    // register a single rule
    //$rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

    $rectorConfig->rules([
        \Rector\TypeDeclaration\Rector\Property\TypedPropertyFromAssignsRector::class,
        \Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector::class,
        \Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictGetterMethodReturnTypeRector::class,
    ]);
    $rectorConfig->rule(\Rector\TypeDeclaration\Rector\Property\TypedPropertyFromAssignsRector::class);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_80,
        SetList::CODE_QUALITY
    ]);
};
