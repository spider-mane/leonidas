<?php

namespace Leonidas\Library\Admin\Component\Page;

use Leonidas\Contracts\Admin\Component\Page\AdminPageLayoutInterface;
use Leonidas\Contracts\Admin\Component\Page\AdminTitleResolverInterface;
use Leonidas\Contracts\Admin\Component\Page\FlexPageInterface;
use Leonidas\Contracts\Admin\Component\Page\LoadErrorPageInterface;
use Leonidas\Contracts\Admin\Component\Page\ParentFileResolverInterface;
use Leonidas\Contracts\Admin\Component\Page\SubmenuFileResolverInterface;
use Leonidas\Enum\Admin\Page\AdminPageContext;
use Leonidas\Library\Admin\Component\Page\Abstracts\NestedPageTrait;

class FlexPage extends MenuPage implements FlexPageInterface
{
    use NestedPageTrait {
        __construct as __nestedPageConstruct;
    }

    protected AdminPageContext $context;

    public function __construct(
        AdminPageContext $context,
        string $pageTitle,
        string $menuTitle,
        string $menuSlug,
        int $position,
        AdminPageLayoutInterface $layout,
        LoadErrorPageInterface $loadErrorPage,
        ?string $iconUrl = null,
        ?string $capability = null,
        ?string $titleInSubmenu = null,
        ?AdminTitleResolverInterface $adminTitleResolver = null,
        ?ParentFileResolverInterface $parentFileResolver = null,
        ?SubmenuFileResolverInterface $subMenuFileResolver = null
    ) {
        $this->context = $context;

        $this->__nestedPageConstruct(
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
