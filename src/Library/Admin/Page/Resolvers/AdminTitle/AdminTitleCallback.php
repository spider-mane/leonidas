<?php

namespace Leonidas\Library\Admin\Page\Resolvers\AdminTitle;

use Leonidas\Contracts\Admin\AdminTitleResolverInterface;

class AdminTitleCallback implements AdminTitleResolverInterface
{
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function resolveAdminTitle(string $adminTitle, string $title): string
    {
        return ($this->callback)($adminTitle, $title);
    }
}
