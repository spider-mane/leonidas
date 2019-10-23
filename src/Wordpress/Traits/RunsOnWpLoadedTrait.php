<?php

namespace Backalley\WordPress\Traits;

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
