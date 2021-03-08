<?php

namespace WebTheory\Leonidas\Framework\Traits\Hooks;

use Closure;

trait TargetsAdminTitleHook
{
    protected function targetAdminTitleHook(): TargetsAdminTitleHook
    {
        add_filter('admin_title', $this->getAdminTitleCallback(), null, PHP_INT_MAX);

        return $this;
    }

    protected function getAdminTitleCallback(): Closure
    {
        return function (string $adminTitle, string $title) {
            return $this->filterAdminTitle($adminTitle, $title);
        };
    }

    abstract protected function filterAdminTitle(string $adminTitle, string $title): string;
}
