<?php

namespace Leonidas\Framework\Theme\Modules\Abstracts;

use Closure;
use Leonidas\Framework\Modules\AbstractModule;

abstract class TimberContextModule extends AbstractModule
{
    public function hook(): void
    {
        add_filter(
            'timber/context',
            Closure::fromCallable([$this, 'getFileReturnValue'])
        );
    }

    public function getFileReturnValue(array $context)
    {
        return require_once $this->file();
    }

    abstract protected function file(): string;
}
