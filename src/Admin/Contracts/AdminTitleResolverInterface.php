<?php

namespace WebTheory\Leonidas\Admin\Contracts;

interface AdminTitleResolverInterface
{
    /**
     *
     */
    public function resolveAdminTitle(string $adminTitle, string $title): string;
}
