<?php

namespace WebTheory\Leonidas\Admin\Contracts;

interface IconGeneratorInterface
{
    /**
     *
     */
    public static function getIcon(string $icon): string;
}
