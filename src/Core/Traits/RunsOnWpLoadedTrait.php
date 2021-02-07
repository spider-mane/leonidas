<?php

namespace WebTheory\Leonidas\Core\Traits;

trait RunsOnWpLoadedTrait
{
    /**
     *
     */
    protected function hook()
    {
        add_action('wp_loaded', [$this, 'run']);
    }

    /**
     *
     */
    abstract public function run();
}
