<?php

namespace WebTheory\Leonidas\AdminPage;

use WebTheory\Html\Html;

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
     *
     */
    public function __construct(string $id, string $title, string $page)
    {
        $this->id = $id;
        $this->title = $title;
        $this->page = $page;
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
     * Get title
     *
     * @return  string
     */
    public function getTitle()
    {
        return $this->title;
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
     *
     */
    public function hook()
    {
        add_action('admin_init', [$this, 'register']);

        return $this;
    }

    /**
     *
     */
    public function register()
    {
        add_settings_section($this->id, $this->title, [$this, 'render'], $this->page);

        return $this;
    }

    /**
     *
     */
    public function render()
    {
        if (!isset($this->callback)) {
            $this->renderDefault();
        } else {
            ($this->callback)($this);
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
