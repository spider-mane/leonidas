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
use Rector\Restoration\Rector\Property\MakeTypedPropertyNullableIfCheckedRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Transform\Rector\ClassMethod\ReturnTypeWillChangeRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictGetterMethodReturnTypeRector;
use Rector\TypeDeclaration\Rector\Property\VarAnnotationIncorrectNullableRector;

return static function (RectorConfig $config): void {
    # Options
    // $config->parallel();
    $config->importNames();
    // $config->importShortClasses();

    # Paths
    $config->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    # Rule Sets
    // $config->sets([LevelSetList::UP_TO_PHP_74]);

    # PHP Rules
    $config->rule(AddArrayDefaultToArrayPropertyRector::class);
    // $config->rule(ReturnTypeWillChangeRector::class);
    // $config->rule(TypedPropertyFromStrictGetterMethodReturnTypeRector::class);

    $config->ruleWithConfiguration(ReturnTypeWillChangeRector::class, [
        // methods
    ]);

    $config->ruleWithConfiguration(TypedPropertyRector::class, [
        TypedPropertyRector::INLINE_PUBLIC => true
    ]);

    # Disabled
    $config->skip([
        # From PHP
        AddDefaultValueForUndefinedVariableRector::class,
        AddLiteralSeparatorToNumberRector::class,
        ClosureToArrowFunctionRector::class,
        CountOnNullRector::class,
        MakeTypedPropertyNullableIfCheckedRector::class,
        RestoreDefaultNullToNullableTypePropertyRector::class,
        ThisCallOnStaticMethodToStaticCallRector::class,
        VarAnnotationIncorrectNullableRector::class,
    ]);
};
