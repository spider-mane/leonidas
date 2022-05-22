<?php

namespace Leonidas\Library\Admin\Component\Page;

use Leonidas\Contracts\Admin\Component\Page\AdminPageLayoutInterface;
use Leonidas\Contracts\Admin\Component\Page\AdminTitleResolverInterface;
use Leonidas\Contracts\Admin\Component\Page\InteriorPageInterface;
use Leonidas\Contracts\Admin\Component\Page\LoadErrorPageInterface;
use Leonidas\Contracts\Admin\Component\Page\ParentFileResolverInterface;
use Leonidas\Contracts\Admin\Component\Page\SubmenuFileResolverInterface;
use Leonidas\Library\Admin\Component\Page\Abstracts\AbstractAdminPage;
use Leonidas\Library\Admin\Component\Page\Abstracts\NestedPageTrait;

class InteriorPage extends AbstractAdminPage implements InteriorPageInterface
{
    use NestedPageTrait {
        __construct as __nestedPageConstruct;
    }

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
        $this->__nestedPageConstruct(
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
