<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsAdminTitleHook
{
    protected function targetAdminTitleHook()
    {
        add_filter(
            'admin_title',
            $this->getAdminTitleCallback(),
            10,
            PHP_INT_MAX
        );

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
