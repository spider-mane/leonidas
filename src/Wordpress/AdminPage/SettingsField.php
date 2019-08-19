<?php

namespace Backalley\Wordpress\AdminPage;

use Backalley\Html\Html;
use Backalley\Form\Fields\Input;
use Backalley\Form\Contracts\FormFieldInterface;

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
        add_action('admin_init', [$this, 'addSettingsField']);

        return $this;
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
     * @param   string  $tab  tab
     *
     * @return  self
     */
    public function setTab(string $tab)
    {
        $this->tab = $tab;

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
    public function setId(string $id)
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
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
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
    public function addSettingsField()
    {
        if (!isset($this->page)) {
            return;
        }

        $args = ['label_for' => $this->id] + $this->displayArgs;

        add_settings_field($this->id, $this->title, [$this, 'render'], $this->page, $this->section, $args);
    }

    /**
     *
     */
    public function render($args)
    {
        $settings = get_registered_settings();
        $setting = $settings[$this->setting];

        if (!isset($this->displayCallback)) {
            $this->renderDefault($setting);
        } else {
            call_user_func($this->displayCallback, $args, $this, $setting);
        }
    }

    /**
     *
     */
    protected function getDefaultField(): FormFieldInterface
    {
        return (new Input)
            ->setClasslist($this->displayArgs['class'] ?? [])
            ->addClass('regular-text')
            ->setType('text');
    }

    /**
     *
     */
    protected function renderDescription($description)
    {
        $this->displayArgs['description_attr']['class'][] = 'description';

        return Html::tag('p', $description, $this->displayArgs['description_attr']);
    }

    /**
     *
     */
    protected function renderDefault(array $setting)
    {
        $default = $setting['default'] ?? null;
        $description = $setting['description'] ?? null;

        if (!isset($this->field)) {
            $this->field = $this->getDefaultField();
        }

        echo $this->field
            ->setName($this->setting)
            ->setValue(get_option($this->setting, $default))
            ->setId($this->id)
            ->toHtml();

        if (isset($description)) {
            echo $this->renderDescription($description);
        }
    }
}
