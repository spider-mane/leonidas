<?php

namespace WebTheory\Leonidas\AdminPage;

class SettingsPage extends AbstractAdminPage
{
    /**
     * tabs
     *
     * @var array
     */
    protected $tabs = [];

    /**
     * @var string
     */
    protected $optionGroup;

    /**
     * @var string
     */
    protected $template = 'settings-page-template';

    /**
     *
     */
    public function __construct(string $menuSlug, string $optionGroup, ?string $capability = null)
    {
        $this->optionGroup = $optionGroup;

        parent::__construct($menuSlug, $capability);
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
     * Get tabs
     *
     * @return  array
     */
    public function getTabs()
    {
        return $this->tabs;
    }

    /**
     * Set tabs
     *
     * @param   array  $tabs
     *
     * @return  self
     */
    public function setTabs(array $tabs)
    {
        $this->tabs = $tabs;

        return $this;
    }

    /**
     *
     */
    protected function getTemplateContext(): array
    {
        return [
            'title' => $this->pageTitle,
            'tabs' => $this->tabs,
            'page' => $this->menuSlug,
            'description' => $this->description,
            'option_group' => $this->optionGroup,
        ];
    }
}
