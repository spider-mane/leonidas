<?php

namespace Leonidas\Library\Admin\Screen;

use Leonidas\Contracts\Admin\Screen\ScreenActionInterface;

class ScreenAction implements ScreenActionInterface
{
    protected array $base;

    /**
     * @var callable
     */
    protected $callback;

    protected array $screens;

    /**
     * ajax actions that callback
     */
    protected array $actions;

    protected function __construct($base, array $screens, callable $callback, array $actions = [])
    {
        $this->base = (array) $base;
        $this->screens = $screens;
        $this->callback = $callback;
        $this->actions = $actions;
    }

    public function getScreens(): array
    {
        return $this->screens;
    }

    public function getScreenMap(): array
    {
        return $this->base;
    }

    public function getAjaxActions(): array
    {
        return $this->actions;
    }

    public function doScreenAction(): void
    {
        ($this->callback)();
    }
}
