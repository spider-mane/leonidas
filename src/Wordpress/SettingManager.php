<?php

namespace Backalley\Wordpress;

use Backalley\Wordpress\Fields\WpAdminField;

class SettingManager extends WpAdminField
{
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
    protected $type = 'string';

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
     * filter
     *
     * @var callable
     */
    protected $filters = ['sanitize_text_field'];

    /**
     * rules
     *
     * @var array
     */
    protected $rules = [];

    /**
     * alerts
     *
     * @var array
     */
    protected $alerts = [];

    /**
     * @var bool
     */
    protected $isSerialized = false;

    /**
     * The index where the targeted value in a serialized data object is to be
     * found. Use dot notation for nested values.
     *
     * @var string
     */
    protected $pointer;

    /**
     * Object that can convert a serialized format to a php readable data format
     * and vice versa. This allows unlimited flexability in allowable
     * serialization formats.
     *
     * @var
     */
    protected $serializedDataReader;

    /**
     * sanitize_callback
     *
     * @var callable
     */
    protected $sanitizeCallback;

    /**
     *
     */
    public function __construct(string $optionGroup, string $optionName)
    {
        $this->setOptionGroup($optionGroup)->setOptionName($optionName);
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
     * Set optionName
     *
     * @param string $optionName
     *
     * @return  self
     */
    private function setOptionName(string $option_name)
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
     * @param callable $sanitize_callback
     *
     * @return self
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
     *
     */
    public function register()
    {
        $args = [
            'type' => $this->type,
            'description' => $this->description,
            'sanitize_callback' => [$this, 'processInput'],
            'show_in_rest' => $this->showInRest,
            'default' => $this->defaultValue,
        ];

        register_setting($this->optionGroup, $this->optionName, $args);
    }

    /**
     *
     */
    public function registerSetting()
    {
        return $this->register();
    }

    /**
     *
     */
    public function processInput($input)
    {
        if (!isset($this->sanitizeCallback)) {
            $input = $this->filterInput($input);
        } else {
            $input = ${$this->sanitizeCallback}($input, $this);
        }

        return $input;
    }

    /**
     *
     */
    protected function filterInput($input)
    {
        if (true === $this->validateInput($input)) {
            return $this->sanitizeInput($input);
        } else {
            return get_option($this->optionName, $this->defaultValue);
        }
    }

    /**
     *
     */
    protected function handleRuleViolation($rule)
    {
        add_settings_error($this->optionName, "invalid-{$rule}", $this->alerts[$rule], 'error');

        return $this;
    }
}
