<?php

namespace Leonidas\Contracts\Extension;

interface BaseModuleInterface
{
    /**
     * @return void
     */
    public function hook(): void;
}
