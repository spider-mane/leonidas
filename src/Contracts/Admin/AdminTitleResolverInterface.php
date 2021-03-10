<?php

namespace Leonidas\Contracts\Admin;

interface AdminTitleResolverInterface
{
    /**
     *
     */
    public function resolveAdminTitle(string $adminTitle, string $title): string;
}
