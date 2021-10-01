<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use PhpCsFixer\Fixer\Operator\NewWithBracesFixer;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenTraits;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use NunoMaduro\PhpInsights\Domain\Sniffs\ForbiddenSetterSniff;
use NunoMaduro\PhpInsights\Domain\Metrics\Architecture\Classes;
use SlevomatCodingStandard\Sniffs\Functions\FunctionLengthSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ReturnTypeHintSniff;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenFinalClasses;
use SlevomatCodingStandard\Sniffs\Functions\UnusedParameterSniff;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenNormalClasses;
use SlevomatCodingStandard\Sniffs\TypeHints\PropertyTypeHintSniff;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenPrivateMethods;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ParameterTypeHintSniff;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenDefineFunctions;
use SlevomatCodingStandard\Sniffs\Commenting\DocCommentSpacingSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DeclareStrictTypesSniff;
use NunoMaduro\PhpInsights\Domain\Insights\CyclomaticComplexityIsHigh;
use SlevomatCodingStandard\Sniffs\Classes\ForbiddenPublicPropertySniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowEmptySniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DisallowMixedTypeHintSniff;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenDefineGlobalConstants;
use SlevomatCodingStandard\Sniffs\Classes\SuperfluousExceptionNamingSniff;
use PHP_CodeSniffer\Standards\PSR12\Sniffs\Classes\ClassInstantiationSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\AlphabeticallySortedUsesSniff;
use SlevomatCodingStandard\Sniffs\Commenting\UselessFunctionDocCommentSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DisallowArrayTypeHintSyntaxSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\NullableTypeForNullDefaultValueSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowShortTernaryOperatorSniff;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Preset
    |--------------------------------------------------------------------------
    |
    | This option controls the default preset that will be used by PHP Insights
    | to make your code reliable, simple, and clean. However, you can always
    | adjust the `Metrics` and `Insights` below in this configuration file.
    |
    | Supported: "default", "laravel", "symfony", "magento2", "drupal"
    |
    */

    'preset' => 'laravel',

    /*
    |--------------------------------------------------------------------------
    | IDE
    |--------------------------------------------------------------------------
    |
    | This options allow to add hyperlinks in your terminal to quickly open
    | files in your favorite IDE while browsing your PhpInsights report.
    |
    | Supported: "textmate", "macvim", "emacs", "sublime", "phpstorm",
    | "atom", "vscode".
    |
    | If you have another IDE that is not in this list but which provide an
    | url-handler, you could fill this config with a pattern like this:
    |
    | myide://open?url=file://%f&line=%l
    |
    */

    'ide' => 'phpstorm',

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may adjust all the various `Insights` that will be used by PHP
    | Insights. You can either add, remove or configure `Insights`. Keep in
    | mind that all added `Insights` must belong to a specific `Metric`.
    |
    */

    'exclude' => [
        //  'path/to/directory-or-file'
    ],

    'add' => [
        Classes::class => [
            ForbiddenFinalClasses::class,
        ],
    ],

    'remove' => [
        AlphabeticallySortedUsesSniff::class,
        DeclareStrictTypesSniff::class,
        DisallowMixedTypeHintSniff::class,
        ForbiddenDefineFunctions::class,
        ForbiddenNormalClasses::class,
        ForbiddenTraits::class,
        ParameterTypeHintSniff::class,
        PropertyTypeHintSniff::class,
        ReturnTypeHintSniff::class,
        UselessFunctionDocCommentSniff::class,
        UnusedParameterSniff::class,
        LineLengthSniff::class,
        DocCommentSpacingSniff::class,
        ClassInstantiationSniff::class,
        NewWithBracesFixer::class,
        NullableTypeForNullDefaultValueSniff::class,
        DisallowArrayTypeHintSyntaxSniff::class,
        NoEmptyCommentFixer::class,
        DisallowShortTernaryOperatorSniff::class,
        ForbiddenPublicPropertySniff::class,
        DisallowEmptySniff::class,
        ForbiddenSetterSniff::class,
        SuperfluousExceptionNamingSniff::class,
        OrderedClassElementsFixer::class,
    ],

    'config' => [
        ForbiddenPrivateMethods::class => [
            'title' => 'The usage of private methods is not idiomatic in Laravel.',
        ],

        ForbiddenDefineGlobalConstants::class => [
            'ignore' => ['LARAVEL_START'],
        ],

        LineLengthSniff::class => [
            'lineLimit' => 100,
            'absoluteLineLimit' => 90,
        ],

        FunctionLengthSniff::class => [
            'maxLinesLength' => 100,
        ],

        OrderedImportsFixer::class => [
            'sort_algorithm' => 'length',
        ],

        CyclomaticComplexityIsHigh::class => [
            'maxComplexity' => 6,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Requirements
    |--------------------------------------------------------------------------
    |
    | Here you may define a level you want to reach per `Insights` category.
    | When a score is lower than the minimum level defined, then an error
    | code will be returned. This is optional and individually defined.
    |
    */

    'requirements' => [
        'min-quality' => 80,
        'min-complexity' => 90,
        'min-architecture' => 80,
        'min-style' => 95,
        'disable-security-check' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Threads
    |--------------------------------------------------------------------------
    |
    | Here you may adjust how many threads (core) PHPInsights can use to perform
    | the analyse. This is optional, don't provide it and the tool will guess
    | the max core number available. This accept null value or integer > 0.
    |
    */

    'threads' => null,

];
