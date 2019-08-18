<?php

namespace Backalley\WordPress\AdminPage;

use Backalley\Html\Html;
use Backalley\Wordpress\AdminPage\AdminSetting;

/**
 *
 */
class SettingsSection
{
    /**
     * id
     *
     * @var string
     */
    public $id;

    /**
     * title
     *
     * @var string
     */
    public $title;

    /**
     * callable
     *
     * @var callable
     */
    public $callback;

    /**
     * page
     *
     * @var string
     */
    public $page;

    /**
     * description
     *
     * @var string
     */
    public $description;

    /**
     * settings
     *
     * @var array
     */
    public $settings;

    /**
     *
     */
    public function __construct(string $id, string $title, ?string $page = null)
    {
        $this->setId($id)->setTitle($title);

        if (isset($page)) {
            $this->setPage($page);
        }
    }

    /**
     *
     */
    public function hook()
    {
        add_action('admin_init', [$this, 'addSettingsSection']);

        return $this;
    }

    /**
     * Get id
     *
     * @return  string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param   string  $id  id
     *
     * @return  self
     */
    private function setId(string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get title
     *
     * @return  string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param   string  $title  title
     *
     * @return  self
     */
    private function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get callback
     *
     * @return  string
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Set callback
     *
     * @param callable  $callback
     *
     * @return self
     */
    public function setCallback(callable $callback)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * Get page
     *
     * @return  string
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set page
     *
     * @param   string  $page  page
     *
     * @return  self
     */
    public function setPage(string $page)
    {
        $this->page = $page;

        /** @var AdminSetting $setting */
        if (!empty($this->settings)) {
            foreach ($this->settings as $setting) {
                $setting->setPage($this->page);
            }
        }

        return $this;
    }

    /**
     * Get description
     *
     * @return  string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param   string  $description  description
     *
     * @return  self
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get settings
     *
     * @return  array
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Set settings
     *
     * @param   array  $settings
     *
     * @return  self
     */
    public function setSettings(array $settings)
    {
        foreach ($settings as $key => $setting) {
            $this->addSetting($setting);
        }

        return $this;
    }

    /**
     *
     */
    public function addSetting(AdminSetting $setting)
    {
        $setting->setSection($this->id);

        if (isset($this->page)) {
            $setting->setPage($this->page);
        }

        $this->settings[] = $setting;

        return $this;
    }

    /**
     *
     */
    public function addSettingsSection()
    {
        add_settings_section($this->id, $this->title, [$this, 'render'], $this->page);
    }

    /**
     *
     */
    public function render()
    {
        if (!isset($this->callback)) {
            $this->renderDefault();
        } else {
            ${$this->callback}($this);
        }
    }

    /**
     *
     */
    public function renderDefault()
    {
        echo Html::tag('p', $this->description);
    }
}
