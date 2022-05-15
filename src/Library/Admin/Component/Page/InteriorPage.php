<?php

namespace Leonidas\Library\Admin\Component\Page;

use Leonidas\Contracts\Admin\AdminTitleResolverInterface;
use Leonidas\Contracts\Admin\Component\AdminPageLayoutInterface;
use Leonidas\Contracts\Admin\Component\InteriorPageInterface;
use Leonidas\Contracts\Admin\Component\LoadErrorPageInterface;
use Leonidas\Contracts\Admin\ParentFileResolverInterface;
use Leonidas\Contracts\Admin\SubmenuFileResolverInterface;
use Leonidas\Library\Admin\Component\Page\Abstracts\AbstractAdminPage;
use Leonidas\Library\Admin\Component\Page\Traits\NestedPageTrait;

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
