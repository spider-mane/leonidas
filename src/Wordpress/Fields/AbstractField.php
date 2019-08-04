<?php

namespace Backalley\Wordpress\Fields;

use Backalley\FormFields\Contracts\FormFieldInterface;
use Backalley\Wordpress\Fields\Contracts\DataFieldInterface;
use Backalley\Wordpress\Fields\Contracts\FieldDataManagerInterface;

/**
 *
 */
abstract class AbstractField implements DataFieldInterface
{
    /**
     * @var string
     */
    protected $slug;

    /**
     * formField
     *
     * @var FormFieldInterface
     */
    protected $formField;

    /**
     * dataManager
     *
     * @var FieldDataManagerInterface
     */
    protected $dataManager;

    /**
     * label
     *
     * @var string
     */
    protected $label;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     *
     */
    protected $containers;

    /**
     * attributes
     *
     * @var string
     */
    protected $attributes = [];

    /**
     *
     */
    protected $template;

    /**
     * Callback function(s) to sanitize incoming data before saving to database
     *
     * @var callable|array
     */
    protected $filters = ['sanitize_textarea_field'];

    /**
     * validation
     *
     * @var string
     */
    protected $rules;

    /**
     * validation_messages
     *
     * @var string
     */
    protected $alerts;

    /**
     * displayCallback
     *
     * @var string
     */
    protected $displayCallback;

    /**
     * getDataCallback
     *
     * @var callback
     */
    protected $getDataCallback;

    /**
     * saveDataCallback
     *
     * @var callback
     */
    protected $saveDataCallback;

    /**
     *
     */
    public function __construct($slug, FormFieldInterface $formField, FieldDataManagerInterface $dataManager)
    {
        $this->slug = $slug;
        $this->setformField($formField);
        $this->setDataManager($dataManager);
    }

    /**
     * Get the value of formField
     *
     * @return  mixed
     */
    public function getformField()
    {
        return $this->formField;
    }

    /**
     * Set the value of formField
     *
     * @param   mixed  $formField
     *
     * @return  self
     */
    public function setformField(FormFieldInterface $formField)
    {
        $this->formField = $formField;

        return $this;
    }

    /**
     * Get the value of dataManager
     *
     * @return  mixed
     */
    public function getDataManager(): FieldDataManagerInterface
    {
        return $this->dataManager;
    }

    /**
     * Set the value of dataManager
     *
     * @param FieldDataManagerInterface  $dataManager
     *
     * @return self
     */
    public function setDataManager(FieldDataManagerInterface $dataManager)
    {
        $dataManager->setField($this);

        $this->dataManager = $dataManager;

        return $this;
    }

    // abstract public function renderField();

    /**
     * Get the value of slug
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Set the value of slug
     *
     * @param string  $slug
     *
     * @return self
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Set label
     *
     * @param string  $label  label
     *
     * @return self
     */
    public function setLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string  $description  description
     *
     * @return self
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get attributes
     *
     * @return string
     */
    public function getAttributes(): string
    {
        return $this->attributes;
    }

    /**
     * Get callback function(s) to sanitize incoming data before saving to database
     *
     * @return callable|array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Set callback function(s) to sanitize incoming data before saving to database
     *
     * @param callable|array  $filters  Callback function(s) to sanitize incoming data before saving to database
     *
     * @return self
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * Get validation
     *
     * @return string
     */
    public function getRules(): string
    {
        return $this->rules;
    }

    /**
     * Set validation
     *
     * @param string  $validation  validation
     *
     * @return self
     */
    public function setRules($rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Get validation_messages
     *
     * @return string
     */
    public function getAlerts(): string
    {
        return $this->alerts;
    }

    /**
     * Set validation_messages
     *
     * @param string  $alerts  validation_messages
     *
     * @return self
     */
    public function setAlerts(string $alerts)
    {
        $this->alerts = $alerts;

        return $this;
    }

    /**
     *
     */
    public function getRawInput()
    {
        return $_POST[$this->formField->getName()];
    }

    /**
     *
     */
    protected function filterInput($input)
    {
        if (false === $this->validateInput($input)) {
            return;
        }

        return $this->sanitizeInput($input);
    }

    /**
     *
     */
    protected function getFilteredInput()
    {
        return $this->filterInput($this->getRawInput());
    }

    /**
     * @todo add validation logic
     */
    protected function validateInput($input)
    {
        foreach ($this->rules as $rule) {
            if (false) {
                // do something

                return false;
            }
        }

        return true;
    }

    /**
     *
     */
    protected function sanitizeInput($input)
    {
        foreach ((array) $this->filters as $filter) {
            $input = $filter($input);
        }

        return $input;
    }

    /**
     *
     */
    protected function sanitizeField($field)
    {
        return sanitize_textarea_field($field);
    }

    /**
     *
     */
    protected function displayAlert($rule)
    {
        //
    }

    /**
     *
     */
    abstract public function hook();
}
