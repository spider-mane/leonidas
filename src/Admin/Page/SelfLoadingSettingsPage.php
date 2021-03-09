<?php

namespace WebTheory\Leonidas\Admin\Page;

use WebTheory\Leonidas\Contracts\Admin\Components\AdminPageLayoutInterface;
use WebTheory\Leonidas\Admin\Page\Components\StandardSettingsPageLayout;

class SelfLoadingSettingsPage extends AbstractSelfLoadingAdminPage
{
    /**
     * @var string
     */
    protected $optionGroup;

    /**
     *
     */
    public function __construct(string $menuSlug, string $optionGroup, ?string $capability = null)
    {
        $this->optionGroup = $optionGroup;
        $this->menuSlug = $menuSlug;
        $capability && $this->capability = $capability;
    }

    /**
     * Get optionGroup
     *
     * @return string
     */
    public function getOptionGroup(): string
    {
        return $this->optionGroup;
    }

    /**
     *
     */
    public function renderPage(array $args)
    {
        $this->layout = $this->createLayout();

        parent::renderPage($args);
    }

    /**
     *
     */
    protected function createLayout(): AdminPageLayoutInterface
    {
        return new StandardSettingsPageLayout($this->menuSlug, $this->optionGroup);
    }
}
