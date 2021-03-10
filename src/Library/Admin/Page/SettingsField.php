<?php

namespace Leonidas\Library\Admin\Page;

use WebTheory\Html\Html;
use WebTheory\Saveyour\Contracts\FormFieldInterface;
use WebTheory\Saveyour\Fields\Text;

class SettingsField
{
    /**
     * id
     *
     * @var string
     */
    protected $id;

    /**
     * title
     *
     * @var string
     */
    protected $title;

    /**
     * page
     *
     * @var string
     */
    protected $page;

    /**
     * section
     *
     * @var string
     */
    protected $section;

    /**
     * The option_name of the
     *
     * @var string
     */
    protected $setting;

    /**
     * display_callback
     *
     * @var callable
     */
    protected $displayCallback;

    /**
     * callback to escape or filter the value
     *
     * @var callable
     */
    protected $displayFilter = 'htmlspecialchars';

    /**
     * display_args
     *
     * @var string
     */
    protected $displayArgs = [];

    /**
     * tab
     *
     * @var string
     */
    protected $tab;

    /**
     * form_field
     *
     * @var FormFieldInterface
     */
    protected $field;

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
     * Get tab
     *
     * @return  string
     */
    public function getTab()
    {
        return $this->tab;
    }

    /**
     * Set tab
     *
     * @param string $tab
     *
     * @return self
     */
    public function setTab(string $tab)
    {
        $this->tab = $tab;

        return $this;
    }

    /**
     * Get id
     *
     * @return string
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
     * Get page
     *
     * @return  string
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Get the option_name of the
     *
     * @return string
     */
    public function getSetting(): string
    {
        return $this->setting;
    }

    /**
     * Set the option_name of the
     *
     * @param string $setting The option_name of the
     *
     * @return self
     */
    public function setSetting(string $setting)
    {
        $this->setting = $setting;

        return $this;
    }

    /**
     * Get display_callback
     *
     * @return  string
     */
    public function getDisplayCallback()
    {
        return $this->displayCallback;
    }

    /**
     * Set display_callback
     *
     * @param callable $display_callback
     *
     * @return self
     */
    public function setDisplayCallback(callable $display_callback)
    {
        $this->displayCallback = $display_callback;

        return $this;
    }

    /**
     * Get section
     *
     * @return  string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set section
     *
     * @param   string  $section  section
     *
     * @return  self
     */
    public function setSection(string $section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get display_args
     *
     * @return  string
     */
    public function getDisplayArgs()
    {
        return $this->displayArgs;
    }

    /**
     * Set display_args
     *
     * @param   array  $display_args  display_args
     *
     * @return  self
     */
    public function setDisplayArgs(array $display_args)
    {
        $this->displayArgs = $display_args;

        return $this;
    }

    /**
     * Get form_field
     *
     * @return  FormFieldInterface
     */
    public function getField(): FormFieldInterface
    {
        return $this->field;
    }

    /**
     * Set form_field
     *
     * @param FormFieldInterface  $field  form_field
     *
     * @return self
     */
    public function setField(FormFieldInterface $field)
    {
        $this->field = $field;

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
        $args = ['label_for' => $this->id] + $this->displayArgs;

        add_settings_field($this->id, $this->title, [$this, 'renderField'], $this->page, $this->section, $args);

        return $this;
    }

    /**
     *
     */
    public function renderField($args)
    {
        $settings = get_registered_settings();
        $setting = $settings[$this->setting];

        if (!isset($this->displayCallback)) {
            $this->renderDefault($setting);
        } else {
            ($this->displayCallback)($args, $setting, $this);
        }
    }

    /**
     * @return FormFieldInterface
     */
    protected function createDefaultField(): FormFieldInterface
    {
        return (new Text)
            ->setClasslist($this->displayArgs['class'] ?? [])
            ->addClass('regular-text');
    }

    /**
     *
     */
    protected function renderDescription($description)
    {
        $this->displayArgs['description_attr']['class'][] = 'description';

        return Html::tag('p', $this->displayArgs['description_attr'], $description);
    }

    /**
     *
     */
    protected function renderDefault(array $setting)
    {
        $default = $setting['default'] ?? null;
        $description = $setting['description'] ?? null;
        $value = $this->escapeValue(get_option($this->setting, $default));

        if (!isset($this->field)) {
            $this->field = $this->createDefaultField();
        }

        echo $this->field
            ->setName($this->setting)
            ->setValue($value)
            ->setId($this->id)
            ->toHtml();

        if (!empty($description)) {
            echo $this->renderDescription($description);
        }
    }

    /**
     *
     */
    protected function escapeValue($value)
    {
        $value = isset($this->displayFilter)
            ? !is_array($value)
            ? call_user_func($this->displayFilter, $value)
            : array_filter($value, $this->displayFilter)
            : $value;

        return $value;
    }
}
