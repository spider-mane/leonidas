<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\Class_\AddArrayDefaultToArrayPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Php56\Rector\FunctionLike\AddDefaultValueForUndefinedVariableRector;
use Rector\Php70\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector;
use Rector\Php71\Rector\FuncCall\CountOnNullRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php80\Rector\FunctionLike\MixedTypeRector;
use Rector\Php81\Rector\Array_\FirstClassCallableRector;
use Rector\Php81\Rector\Class_\MyCLabsClassToEnumRector;
use Rector\Php81\Rector\ClassMethod\NewInInitializerRector;
use Rector\Php81\Rector\FuncCall\NullToStrictStringFuncCallArgRector;
use Rector\Php81\Rector\MethodCall\MyCLabsMethodCallToEnumConstRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Transform\Rector\ClassMethod\ReturnTypeWillChangeRector;

return RectorConfig::configure()
    # Options
    // ->withImportNames()

    # Paths
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])

    ->withRules([
        // MyCLabsClassToEnumRector::class,
        // MyCLabsMethodCallToEnumConstRector::class,
        FirstClassCallableRector::class,
    ])

    # Sets
    // ->withSets([LevelSetList::UP_TO_PHP_81])

    # Disable
    ->withSkip([
        # PHP 8.1
        NewInInitializerRector::class,
        NullToStrictStringFuncCallArgRector::class,
        ReadOnlyPropertyRector::class,
        ClassPropertyAssignToConstructorPromotionRector::class,

        # PHP 8.0
        MixedTypeRector::class,

        # PHP 7.4
        // AddLiteralSeparatorToNumberRector::class,
        ClosureToArrowFunctionRector::class,
        RestoreDefaultNullToNullableTypePropertyRector::class,

        # PHP 7.1
        // CountOnNullRector::class,

        # PHP 7.0
        ThisCallOnStaticMethodToStaticCallRector::class,

        # PHP 5.6
        // AddDefaultValueForUndefinedVariableRector::class,
    ])

    # PHP
    // ->withConfiguredRule(TypedPropertyRector::class, [
    //     TypedPropertyRector::INLINE_PUBLIC => true,
    // ])

    # Coding Style
    // ->withRules([AddArrayDefaultToArrayPropertyRector::class])

    # Transform
    ->withConfiguredRule(ReturnTypeWillChangeRector::class, [
        // methods
    ]);
