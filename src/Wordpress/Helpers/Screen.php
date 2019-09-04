<?php

namespace Backalley\Wordpress\Helpers;

class Screen
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
    protected $screen;

    /**
     *
     */
    protected function __construct($base, array $screen, callable $callback)
    {
        $this->base = (array) $base;
        $this->screen = $screen;
        $this->callback = $callback;

        add_action('current_screen', [$this, '_load'], null, PHP_INT_MAX);
    }

    /**
     *
     */
    public static function load($base, array $screen, callable $callback)
    {
        return new static($base, $screen, $callback);
    }

    /**
     *
     */
    public function _load($screen)
    {
        if (!in_array($screen->base, (array) $this->base)) {
            return;
        }

        foreach ($this->screen as $property => $value) {
            if ($screen->{$property} !== $value) {
                return;
            }
        }

        call_user_func($this->callback, $screen);
    }
}
