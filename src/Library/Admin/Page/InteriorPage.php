<?php

namespace Leonidas\Library\Admin\Page;

use Leonidas\Contracts\Admin\AdminTitleResolverInterface;
use Leonidas\Contracts\Admin\Components\AdminPageLayoutInterface;
use Leonidas\Contracts\Admin\Components\InteriorPageInterface;
use Leonidas\Contracts\Admin\Components\LoadErrorPageInterface;
use Leonidas\Contracts\Admin\ParentFileResolverInterface;
use Leonidas\Contracts\Admin\SubmenuFileResolverInterface;
use Leonidas\Library\Admin\Page\Traits\NestedPageTrait;

class InteriorPage extends AbstractAdminPage implements InteriorPageInterface
{
    use NestedPageTrait;

    public function __construct(
        string $parentSlug,
        string $pageTitle,
        string $menuSlug,
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
            $menuSlug,
            $layout,
            $loadErrorPage,
            $capability,
            $adminTitleResolver
        );
    }
}
