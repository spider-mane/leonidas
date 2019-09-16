<?php

namespace Backalley\Wordpress\AdminPage;

class SettingsPage extends AdminPage
{
    /**
     * tabs
     *
     * @var array
     */
    protected $tabs = [];

    /**
     * field_groups
     *
     * @var array
     */
    protected $fieldGroups = [];

    /**
     * @var string
     */
    protected $template = 'settings-page-template';

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
     * Get field_groups
     *
     * @return  array
     */
    public function getFieldGroups()
    {
        return $this->fieldGroups;
    }

    /**
     * Set field_groups
     *
     * @param   mixed  $fieldGroups  fields
     *
     * @return  self
     */
    public function addFieldGroups(string ...$fieldGroups)
    {
        foreach ($fieldGroups as $fieldGroup) {
            $this->fieldGroups[] = $fieldGroup;
        }

        return $this;
    }

    /**
     *
     */
    public function renderDefault()
    {
        echo $this->renderTemplate([
            'title' => $this->pageTitle,
            'tabs' => $this->tabs,
            'page' => $this->menuSlug,
            'description' => $this->description,
            'field_groups' => $this->fieldGroups,
        ]);
    }
}
