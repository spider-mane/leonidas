<?php

namespace Leonidas\Library\System\Setting;

use Leonidas\Contracts\System\Setting\SettingHandlerInterface;

class CallbackSettingHandler implements SettingHandlerInterface
{
    /**
     * @var callable
     */
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function handleInput($input)
    {
        return ($this->callback)($input);
    }
}
