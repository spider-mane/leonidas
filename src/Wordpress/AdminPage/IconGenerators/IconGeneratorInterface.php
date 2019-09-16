<?php

namespace Backalley\Wordpress\AdminPage\IconGenerators;

interface IconGeneratorInterface
{
    /**
     *
     */
    public static function getIcon(string $icon): string;
}
