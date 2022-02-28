<?php

namespace Leonidas\Library\Admin\Page;

use Leonidas\Contracts\Admin\AdminTitleResolverInterface;
use Leonidas\Contracts\Admin\Components\AdminPageLayoutInterface;
use Leonidas\Contracts\Admin\Components\FlexPageInterface;
use Leonidas\Contracts\Admin\Components\LoadErrorPageInterface;
use Leonidas\Contracts\Admin\ParentFileResolverInterface;
use Leonidas\Contracts\Admin\SubmenuFileResolverInterface;
use Leonidas\Enum\Admin\Page\AdminPageContext;
use Leonidas\Library\Admin\Page\Traits\NestedPageTrait;

class FlexPage extends MenuPage implements FlexPageInterface
{
    use NestedPageTrait;

    protected AdminPageContext $context;

    public function __construct(
        AdminPageContext $context,
        string $pageTitle,
        string $menuTitle,
        string $menuSlug,
        int $position,
        AdminPageLayoutInterface $layout,
        LoadErrorPageInterface $loadErrorPage,
        ?string $iconUrl,
        ?string $capability = null,
        ?string $titleInSubmenu,
        ?AdminTitleResolverInterface $adminTitleResolver = null,
        ?ParentFileResolverInterface $parentFileResolver = null,
        ?SubmenuFileResolverInterface $subMenuFileResolver = null
    ) {
        $this->context = $context;

        NestedPageTrait::__construct(
            $pageTitle,
            $parentFileResolver,
            $subMenuFileResolver
        );

        parent::__construct(
            $pageTitle,
            $menuTitle,
            $menuSlug,
            $position,
            $layout,
            $loadErrorPage,
            $iconUrl,
            $capability,
            $titleInSubmenu,
            $adminTitleResolver
        );
    }

    public function getContext(): AdminPageContext
    {
        return $this->context;
    }

    public function setContext(AdminPageContext $context)
    {
        $this->context = $context;
    }
}
