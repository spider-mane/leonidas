<?php

namespace Backalley\WordPress\Contracts;

interface IconGeneratorInterface
{
    /**
     *
     */
    public static function getIcon(string $icon): string;
}
