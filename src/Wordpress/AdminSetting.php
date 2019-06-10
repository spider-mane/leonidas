<?php

namespace Backalley\Wordpress;

use Backalley\FormFields\Input;


/**
 * @package Backalley-Core
 */
class AdminSetting extends ApiBase
{
    /**
     * option_group
     * 
     * @var string
     */
    public $option_group;

    /**
     * option_name
     * 
     * @var string
     */
    public $option_name;

    /**
     * type
     * 
     * @var string
     */
    public $type;

    /**
     * description
     * 
     * @var string
     */
    public $description;

    /**
     * sanitize_callback
     * 
     * @var callable
     */
    public $sanitize_callback;

    /**
     * show_in_rest
     * 
     * @var bool
     */
    public $show_in_rest;

    /**
     * default
     * 
     * @var mixed
     */
    public $default;

    /**
     * autoload_option
     * 
     * @var mixed
     */
    public $autoload_option = true;

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
     * display_callback
     * 
     * @var callable
     */
    public $display_callback;

    /**
     * page
     * 
     * @var string
     */
    public $page;

    /**
     * section
     * 
     * @var string
     */
    public $section;

    /**
     * display_args
     * 
     * @var string
     */
    public $display_args = [];

    /**
     * tab
     * 
     * @var string
     */
    public $tab;

    /**
     * form_field
     * 
     * @var FormFieldInterface
     */
    public $form_field;

    /**
     * 
     */
    public function __construct($args)
    {
        parent::__construct($args);

        // $this->set_dynamic_defaults();

        add_action('admin_init', [$this, 'create_setting']);
    }

    /**
     * 
     */
    public static function create($settings)
    {
        foreach ($settings as $index => $args) {
            $settings[$index] = new static($args);
        }

        return $settings;
    }

    /**
     * 
     */
    protected function set_dynamic_defaults()
    {
        $defaults = [];

        foreach ($defaults as $property => $default) {
            if (!isset($this->$property)) {
                $this->$property = $default;
            }
        }

        return $this;
    }

    /**
     * Get option_group
     *
     * @return  string
     */
    public function get_option_group()
    {
        return $this->option_group;
    }

    /**
     * Set option_group
     *
     * @param   string  $option_group  option_group
     *
     * @return  self
     */
    public function set_option_group(string $option_group)
    {
        $this->option_group = $option_group;

        return $this;
    }

    /**
     * Get option_name
     *
     * @return  string
     */
    public function get_option_name()
    {
        return $this->option_name;
    }

    /**
     * Set option_name
     *
     * @param   string  $option_name  option_name
     *
     * @return  self
     */
    public function set_option_name(string $option_name)
    {
        $this->option_name = $option_name;

        return $this;
    }

    /**
     * Get type
     *
     * @return  string
     */
    public function get_type()
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
    public function set_type(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get description
     *
     * @return  string
     */
    public function get_description()
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
    public function set_description(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get sanitize_callback
     *
     * @return  callback
     */
    public function get_sanitize_callback()
    {
        return $this->sanitize_callback;
    }

    /**
     * Set sanitize_callback
     *
     * @param   callable  $sanitize_callback
     *
     * @return  self
     */
    public function set_sanitize_callback(callable $sanitize_callback)
    {
        $this->sanitize_callback = $sanitize_callback;

        return $this;
    }

    /**
     * Get show_in_rest
     *
     * @return  bool
     */
    public function get_show_in_rest()
    {
        return $this->show_in_rest;
    }

    /**
     * Set show_in_rest
     *
     * @param   bool  $show_in_rest  show_in_rest
     *
     * @return  self
     */
    public function set_show_in_rest(bool $show_in_rest)
    {
        $this->show_in_rest = $show_in_rest;

        return $this;
    }

    /**
     * Get default
     *
     * @return  mixed
     */
    public function get_default()
    {
        return $this->default;
    }

    /**
     * Set default
     *
     * @param   mixed  $default  default
     *
     * @return  self
     */
    public function set_default($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Get field
     *
     * @return  string
     */
    public function get_field()
    {
        return $this->field;
    }

    /**
     * Set field
     *
     * @param   string  $field  field
     *
     * @return  self
     */
    public function set_field(string $field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get tab
     *
     * @return  string
     */
    public function get_tab()
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
    public function set_tab(string $tab)
    {
        $this->tab = $tab;

        return $this;
    }

    /**
     * Get id
     *
     * @return  string
     */
    public function get_id()
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
    public function set_id(string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get title
     *
     * @return  string
     */
    public function get_title()
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
    public function set_title(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get display_callback
     *
     * @return  string
     */
    public function get_display_callback()
    {
        return $this->display_callback;
    }

    /**
     * Set display_callback
     *
     * @param callable $display_callback
     *
     * @return self
     */
    public function set_display_callback(callable $display_callback)
    {
        $this->display_callback = $display_callback;

        return $this;
    }

    /**
     * Get page
     *
     * @return  string
     */
    public function get_page()
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
    public function set_page(string $page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get section
     *
     * @return  string
     */
    public function get_section()
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
    public function set_section(string $section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get display_args
     *
     * @return  string
     */
    public function get_display_args()
    {
        return $this->display_args;
    }

    /**
     * Set display_args
     *
     * @param   array  $display_args  display_args
     *
     * @return  self
     */
    public function set_display_args(array $display_args)
    {
        $this->display_args = $display_args;

        return $this;
    }

    /**
     * Get form_field
     *
     * @return  FormFieldInterface
     */
    public function get_form_field()
    {
        return $this->form_field;
    }

    /**
     * Set form_field
     *
     * @param   FormFieldInterface  $form_field  form_field
     *
     * @return  self
     */
    public function set_form_field($form_field)
    {
        $this->form_field = $form_field;

        return $this;
    }

    /**
     * 
     */
    public function create_setting()
    {
        $args = [
            'type' => $this->type,
            'description' => $this->description,
            'sanitize_callback' => [$this, 'sanitize'],
            'show_in_rest' => $this->show_in_rest,
            'default' => $this->default,
        ];
        register_setting($this->option_group, $this->option_name, $args);

        $args = ['label_for' => $this->id] + $this->display_args;
        add_settings_field($this->id, $this->title, [$this, 'render'], $this->page, $this->section, $args);
    }

    /**
     * 
     */
    public function remove_setting()
    {
        //
    }

    /**
     * 
     */
    public function render($args)
    {
        if (isset($this->field)) {
            $this->field->render();

        } elseif (isset($this->display_callback)) {
            $callback = $this->display_callback;
            $callback($this, $args);

        } else {
            $this->render_default($args);
        }
    }

    /**
     * 
     */
    protected function render_default($args)
    {
        echo new Input([
            'value' => get_option($this->option_name),
            'name' => $this->option_name,
            'type' => 'text',
            'attributes' => [
                'id' => $this->id,
                'class' => 'regular-text',
            ]
        ]);
    }

    /**
     * 
     */
    public function sanitize($value)
    {
        if (isset($this->field)) {
            $value = $this->field->save('false');

        } elseif (isset($this->sanitize_callback)) {
            $callback = $this->sanitize_callback;
            $value = $callback($value, $this);

        } else {
            $value = $this->sanitize_default($value);
        }

        return $value;
    }

    /**
     * 
     */
    protected function sanitize_default($value)
    {
        return sanitize_text_field($value);
    }
}
