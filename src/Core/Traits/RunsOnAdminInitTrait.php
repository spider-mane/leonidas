<?php

namespace WebTheory\Leonidas\Core\Traits;

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
