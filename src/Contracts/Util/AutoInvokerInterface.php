<?php

namespace Leonidas\Contracts\Util;

use Closure;

interface AutoInvokerInterface
{
    /**
     * @param string|Closure|array<int,object|string> $function
     *
     * @return mixed
     */
    public function invoke($function);

    /**
     * @param string|Closure|array<int,object|string> $function
     */
    public function resolve($function): array;
}
