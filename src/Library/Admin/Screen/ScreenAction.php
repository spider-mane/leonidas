<?php

namespace Leonidas\Library\Admin\Screen;

use Leonidas\Contracts\Admin\Screen\ScreenActionInterface;

class ScreenAction implements ScreenActionInterface
{
    /**
     * @var array
     */
    protected $base;

    /**
     * @var callable
     */
    protected $callback;

    /**
     * @var array
     */
    protected $screens;

    /**
     * ajax actions that callback
     * @var array
     */
    protected $actions;

    /**
     *
     */
    protected function __construct($base, array $screens, callable $callback, array $actions = [])
    {
        $this->base = (array) $base;
        $this->screens = $screens;
        $this->callback = $callback;
        $this->actions = $actions;
    }
}
