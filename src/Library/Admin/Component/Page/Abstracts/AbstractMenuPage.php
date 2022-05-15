<?php

namespace Leonidas\Library\Admin\Component\Page\Abstracts;

use Leonidas\Contracts\Admin\AdminTitleResolverInterface;
use Leonidas\Contracts\Admin\Component\AdminPageLayoutInterface;
use Leonidas\Contracts\Admin\Component\LoadErrorPageInterface;

abstract class AbstractMenuPage extends AbstractAdminPage
{
    protected string $menuTitle = '';

    protected int $position;

    public function __construct(
        string $pageTitle,
        string $menuTitle,
        string $menuSlug,
        int $position,
        AdminPageLayoutInterface $layout,
        LoadErrorPageInterface $loadErrorPage,
        ?string $capability = null,
        ?AdminTitleResolverInterface $adminTitleResolver = null
    ) {
        $this->menuTitle = $menuTitle;
        $this->position = $position;

        parent::__construct(
            $pageTitle,
            $menuSlug,
            $layout,
            $loadErrorPage,
            $capability,
            $adminTitleResolver
        );
    }

    public function getMenuTitle(): string
    {
        return $this->menuTitle;
    }

    public function getPosition(): int
    {
        return $this->position;
    }
}
