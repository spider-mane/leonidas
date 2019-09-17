<?php

namespace Backalley\Wordpress\Contracts;

interface IconGeneratorInterface
{
    /**
     *
     */
    public static function getIcon(string $icon): string;
}
