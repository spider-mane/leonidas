<?php

namespace WebTheory\Leonidas\Traits;

trait RunsOnAdminInitTrait
{
    /**
     *
     */
    protected function hook()
    {
        add_action('admin_init', [$this, 'run']);
    }

    /**
     *
     */
    abstract public function run();
}
