<?php

namespace WebTheory\Leonidas;

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
     * ajax actions that callback
     * @var array
     */
    protected $actions;

    /**
     *
     */
    protected function __construct($base, array $screen, callable $callback, $actions = null)
    {
        $this->base = (array) $base;
        $this->screen = $screen;
        $this->callback = $callback;

        if (isset($actions)) {
            $this->actions = (array) $actions;
        }
    }

    /**
     *
     */
    protected function hook()
    {
        add_action('current_screen', [$this, 'screen']);

        if (isset($this->actions)) {
            add_action('admin_init', [$this, 'ajax']);
        }

        return $this;
    }

    /**
     *
     */
    public static function load($base, array $screen, callable $callback, $actions = null)
    {
        return (new static($base, $screen, $callback, $actions))->hook();
    }

    /**
     *
     */
    public function screen($screen)
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

    /**
     *
     */
    public function ajax()
    {
        if (true !== wp_doing_ajax() || !in_array($_REQUEST['action'], $this->actions)) {
            return;
        }

        call_user_func($this->callback);
    }
}
