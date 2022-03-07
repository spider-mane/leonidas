<?php

namespace Contracts\Extension;

interface SpecialModuleRegistrarInterface
{
    public function getType(): string;

    public function register($module);
}
