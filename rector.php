<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php70\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector;
use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Transform\Rector\ClassMethod\ReturnTypeWillChangeRector;

return static function (RectorConfig $config): void {
    # Options
    $config->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $config->importNames();

    # Sets
    $config->sets([LevelSetList::UP_TO_PHP_74]);

    # Remove from sets
    $config->skip([
        # From PHP
        AddLiteralSeparatorToNumberRector::class,
        RestoreDefaultNullToNullableTypePropertyRector::class,
        ThisCallOnStaticMethodToStaticCallRector::class
    ]);

    # PHP Rules
    $config->ruleWithConfiguration(ReturnTypeWillChangeRector::class, [
        // methods
    ]);

    $config->ruleWithConfiguration(TypedPropertyRector::class, [
        TypedPropertyRector::INLINE_PUBLIC => true
    ]);
};
