<?php

namespace Leonidas\Library\Admin\Page;

use Leonidas\Contracts\Admin\AdminTitleResolverInterface;
use Leonidas\Contracts\Admin\Components\AdminPageLayoutInterface;
use Leonidas\Contracts\Admin\Components\LoadErrorPageInterface;
use Leonidas\Contracts\Admin\Components\SubmenuPageInterface;
use Leonidas\Contracts\Admin\ParentFileResolverInterface;
use Leonidas\Contracts\Admin\SubmenuFileResolverInterface;
use Leonidas\Library\Admin\Page\Traits\NestedPageTrait;

class SubmenuPage extends AbstractMenuPage implements SubmenuPageInterface
{
    use NestedPageTrait;

    public function __construct(
        string $parentSlug,
        string $pageTitle,
        string $menuTitle,
        string $menuSlug,
        int $position,
        AdminPageLayoutInterface $layout,
        LoadErrorPageInterface $loadErrorPage,
        ?string $capability = null,
        ?AdminTitleResolverInterface $adminTitleResolver = null,
        ?ParentFileResolverInterface $parentFileResolver = null,
        ?SubmenuFileResolverInterface $subMenuFileResolver = null
    ) {
        NestedPageTrait::__construct(
            $parentSlug,
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
            $capability,
            $adminTitleResolver
        );
    }
}
