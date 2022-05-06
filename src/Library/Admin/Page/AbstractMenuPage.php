<?php

namespace Leonidas\Library\Admin\Page;

use Leonidas\Contracts\Admin\AdminTitleResolverInterface;
use Leonidas\Contracts\Admin\Components\AdminPageLayoutInterface;
use Leonidas\Contracts\Admin\Components\LoadErrorPageInterface;

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
