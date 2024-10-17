<?php

namespace Leonidas\Contracts\System\Configuration;

interface ModelInfoInterface
{
    public function getPluralLabel(): string;

    public function getSingularLabel(): string;

    public function getDescription(): string;
}
