<?php

namespace Leonidas\Library\Admin\Component\Page;

use Leonidas\Contracts\Admin\AdminTitleResolverInterface;
use Leonidas\Contracts\Admin\Component\AdminPageLayoutInterface;
use Leonidas\Contracts\Admin\Component\LoadErrorPageInterface;
use Leonidas\Contracts\Admin\Component\SubmenuPageInterface;
use Leonidas\Contracts\Admin\ParentFileResolverInterface;
use Leonidas\Contracts\Admin\SubmenuFileResolverInterface;
use Leonidas\Library\Admin\Component\Page\Abstracts\AbstractMenuPage;
use Leonidas\Library\Admin\Component\Page\Traits\NestedPageTrait;

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
