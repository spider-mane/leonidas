<?php

namespace Leonidas\Contracts\Localization;

interface LocalizerInterface
{
    public function translate(string $text): string;

    public function pluralize(string $single, string $plural, int $count): string;
}
