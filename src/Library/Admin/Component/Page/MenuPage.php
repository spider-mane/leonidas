<?php

namespace Leonidas\Library\Admin\Component\Page;

use Leonidas\Contracts\Admin\Component\Page\AdminPageLayoutInterface;
use Leonidas\Contracts\Admin\Component\Page\AdminTitleResolverInterface;
use Leonidas\Contracts\Admin\Component\Page\LoadErrorPageInterface;
use Leonidas\Contracts\Admin\Component\Page\MenuPageInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Leonidas\Library\Admin\Component\Page\Abstracts\AbstractMenuPage;

class MenuPage extends AbstractMenuPage implements MenuPageInterface
{
    use CanBeRestrictedTrait;

    protected ?string $iconUrl;

    /**
     * @var bool|string
     */
    protected $shownInSubmenu;

    public function __construct(
        string $pageTitle,
        string $menuTitle,
        string $menuSlug,
        int $position,
        AdminPageLayoutInterface $layout,
        LoadErrorPageInterface $loadErrorPage,
        ?string $iconUrl,
        ?string $capability = null,
        $shownInSubmenu = null,
        ?AdminTitleResolverInterface $adminTitleResolver = null
    ) {
        $this->iconUrl = $iconUrl;
        $shownInSubmenu && $this->shownInSubmenu = $shownInSubmenu;

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

    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }

    public function getTitleInSubmenu(): string
    {
        return $this->shownInSubmenu;
    }
}
