<?php

namespace Leonidas\Library\Admin\Component\Page;

use Leonidas\Contracts\Admin\Component\Page\AdminPageLayoutInterface;
use Leonidas\Contracts\Admin\Component\Page\AdminTitleResolverInterface;
use Leonidas\Contracts\Admin\Component\Page\LoadErrorPageInterface;
use Leonidas\Contracts\Admin\Component\Page\ParentFileResolverInterface;
use Leonidas\Contracts\Admin\Component\Page\SubmenuFileResolverInterface;
use Leonidas\Contracts\Admin\Component\Page\SubmenuPageInterface;
use Leonidas\Library\Admin\Component\Page\Abstracts\AbstractMenuPage;
use Leonidas\Library\Admin\Component\Page\Traits\NestedPageTrait;

class SubmenuPage extends AbstractMenuPage implements SubmenuPageInterface
{
    use NestedPageTrait {
        __construct as __nestedPageConstruct;
    }

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
        $this->__nestedPageConstruct(
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
