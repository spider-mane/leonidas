<?php

namespace WebTheory\Voltaire;

class TimberContext
{
    /**
     *
     */
    protected $file;

    /**
     *
     */
    protected function __construct(string $file)
    {
        if (file_exists($file)) {
            $this->file = $file;
        } else {
            throw new \Exception($file . ' cannot be found');
        }
    }

    /**
     *
     */
    protected function hook()
    {
        add_filter('timber/context', [$this, 'pass'], PHP_INT_MAX, 1);

        return $this;
    }

    /**
     *
     */
    public function pass($context)
    {
        return include $this->file;
    }

    /**
     *
     */
    public static function load(string $file)
    {
        return (new static($file))->hook();
    }

    /**
     *
     */
    public static function call(callable $callback)
    {
        //
    }
}
