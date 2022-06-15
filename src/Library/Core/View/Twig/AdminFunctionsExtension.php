<?php

namespace Leonidas\Library\Core\View\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFunction;

class AdminFunctionsExtension extends AbstractExtension implements ExtensionInterface
{
    public const FUNCTIONS = [
        'do_meta_boxes',
        'do_settings_sections',
        'settings_errors',
        'settings_fields',
        'submit_button',
    ];

    public function getFunctions()
    {
        if (!is_admin()) {
            return [];
        }

        return array_map(
            fn ($function) => new TwigFunction($function, $function),
            self::FUNCTIONS
        );
    }
}
