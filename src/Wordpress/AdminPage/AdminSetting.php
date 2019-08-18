<?php

namespace Backalley\Wordpress\AdminPage;

use Backalley\Html\Html;
use Backalley\Form\Fields\Input;
use Backalley\Form\Contracts\FormFieldInterface;
use Backalley\Form\Contracts\FormFieldControllerInterface;

class AdminSetting
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
     * option_group
     *
     * @var string
     */
    protected $optionGroup;

    /**
     * option_name
     *
     * @var string
     */
    protected $optionName;

    /**
     * type
     *
     * @var string
     */
    protected $type;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     * default
     *
     * @var mixed
     */
    protected $defaultValue;

    /**
     * show_in_rest
     *
     * @var bool
     */
    protected $showInRest;

    /**
     * autoload_option
     *
     * @var mixed
     */
    protected $autoloadOption = true;

    /**
     * sanitize_callback
     *
     * @var callable
     */
    protected $sanitizeCallback;

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
     * @var FormFieldControllerInterface
     */
    protected $field;

    /**
     *
     */
    public function __construct()
    {
        //
    }

    /**
     *
     */
    public function hook()
    {
        add_action('admin_init', [$this, 'registerSetting']);

        return $this;
    }

    /**
     * Get option_group
     *
     * @return  string
     */
    public function getOptionGroup()
    {
        return $this->optionGroup;
    }

    /**
     * Set option_group
     *
     * @param   string  $option_group  option_group
     *
     * @return  self
     */
    public function setOptionGroup(string $option_group)
    {
        $this->optionGroup = $option_group;

        return $this;
    }

    /**
     * Get option_name
     *
     * @return  string
     */
    public function getOptionName()
    {
        return $this->optionName;
    }

    /**
     * Set option_name
     *
     * @param   string  $option_name  option_name
     *
     * @return  self
     */
    public function setOptionName(string $option_name)
    {
        $this->optionName = $option_name;

        return $this;
    }

    /**
     * Get type
     *
     * @return  string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param   string  $type  type
     *
     * @return  self
     */
    public function setType(string $type)
    {
        $this->type = $type;

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
     * Get sanitize_callback
     *
     * @return  callback|null
     */
    public function getSanitizeCallback()
    {
        return $this->sanitizeCallback;
    }

    /**
     * Set sanitize_callback
     *
     * @param   callable  $sanitize_callback
     *
     * @return  self
     */
    public function setSanitizeCallback(callable $sanitize_callback)
    {
        $this->sanitizeCallback = $sanitize_callback;

        return $this;
    }

    /**
     * Get show_in_rest
     *
     * @return  bool
     */
    public function isShownInRest()
    {
        return $this->showInRest;
    }

    /**
     * Set show_in_rest
     *
     * @param   bool  $show_in_rest  show_in_rest
     *
     * @return  self
     */
    public function setShowInRest(bool $show_in_rest)
    {
        $this->showInRest = $show_in_rest;

        return $this;
    }

    /**
     * Get default
     *
     * @return  mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Set default
     *
     * @param   mixed  $default  default
     *
     * @return  self
     */
    public function setDefaultValue($default)
    {
        $this->defaultValue = $default;

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
     * @return  FormFieldControllerInterface
     */
    public function getField(): FormFieldControllerInterface
    {
        return $this->field;
    }

    /**
     * Set form_field
     *
     * @param FormFieldControllerInterface  $field  form_field
     *
     * @return self
     */
    public function setField(FormFieldControllerInterface $field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     *
     */
    public function registerSetting()
    {
        // create setting that corresponds to an option
        if (isset($this->optionName, $this->optionGroup)) {

            $args = [
                'type' => $this->type,
                'description' => $this->description,
                'sanitize_callback' => [$this, 'sanitizeInput'],
                'show_in_rest' => $this->showInRest,
                'default' => $this->defaultValue,
            ];

            register_setting($this->optionGroup, $this->optionName, $args);
        }

        // create setting field
        if (isset($this->id, $this->title, $this->page)) {

            $args = ['label_for' => $this->id] + $this->displayArgs;

            add_settings_field($this->id, $this->title, [$this, 'render'], $this->page, $this->section, $args);
        }
    }

    /**
     *
     */
    public function removeSetting()
    {
        //
    }

    /**
     *
     */
    public function render($args)
    {
        if (isset($this->displayCallback)) {

            call_user_func($this->displayCallback, $args, $this);
            //
        } elseif (isset($this->field)) {

            echo $this->field
                ->setPostVar($this->optionName)
                ->getFormField()
                ->setId($this->id);

            if (isset($this->description)) {
                echo $this->renderDescription($args);
            }
            //
        } else {
            $this->renderDefault($args);
        }
    }

    /**
     *
     */
    protected function renderDescription($args)
    {
        $args['description_attr']['class'][] = 'description';

        return Html::tag('p', $this->description, $args['description_attr']);
    }

    /**
     *
     */
    protected function renderDefault($args)
    {
        echo (new Input)
            ->setType('text')
            ->setValue(get_option($this->optionName))
            ->setName($this->optionName)
            ->setId($this->id)
            ->addClass('regular-text');

        if (isset($this->description)) {
            echo $this->renderDescription($args);
        }
    }

    /**
     *
     */
    public function sanitizeInput($input)
    {
        if (isset($this->sanitizeCallback)) {

            $input = ${$this->sanitizeCallback}($input, $this);
            //
        } elseif (isset($this->field)) {

            $this->field->setPostVar($this->getOptionName());
            $input = $this->field->getFilteredInput();
            //
        } else {
            $input = $this->sanitizeDefault($input);
        }

        return $input;
    }

    /**
     *
     */
    protected function sanitizeDefault($value)
    {
        return sanitize_text_field($value);
    }
}
