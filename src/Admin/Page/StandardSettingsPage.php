<?php

namespace WebTheory\Leonidas\Admin\Page;

use WebTheory\Leonidas\Admin\Contracts\AdminPageLayoutInterface;
use WebTheory\Leonidas\Admin\Page\Components\StandardSettingsPageLayout;

class StandardSettingsPage extends AdminPage
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
    public function renderPage(array $args = [])
    {
        $this->setLayout($this->createLayout());

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
