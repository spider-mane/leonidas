<?php

namespace Backalley\Wordpress\Load;

class Screen
{
    /**
     *
     */
    protected $base;

    /**
     *
     */
    protected $callback;

    /**
     *
     */
    protected $screen;

    /**
     *
     */
    protected function __construct($base, $screen, $callback)
    {
        $this->base = $base;
        $this->screen = $screen;
        $this->callback = $callback;

        add_action('current_screen', [$this, '_load'], null, PHP_INT_MAX);
    }

    /**
     *
     */
    public static function load($base, $screen, $callback)
    {
        return new static($base, $screen, $callback);
    }

    /**
     *
     */
    public function _load($screen)
    {
        if ($screen->base !== $this->base) {
            return;
        }

        foreach ($this->screen as $property => $value) {
            if ($screen->{$property} !== $value) {
                return;
            }
        }

        call_user_func($this->callback);
    }
}
