<?php

namespace Leonidas\Library\Admin\Setting;

use Closure;
use Leonidas\Contracts\Admin\Setting\SettingHandlerInterface;

class LazyLoadedSettingHandler implements SettingHandlerInterface
{
    protected Closure $callback;

    public function __construct(Closure $callback)
    {
        $this->callback = $callback;
    }

    public function handleInput($input)
    {
        return ($this->callback)($input);
    }
}
