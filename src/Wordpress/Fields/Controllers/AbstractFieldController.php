<?php

namespace Backalley\Wordpress\Fields\Controllers;

use Backalley\FormFields\Contracts\FormFieldInterface;
use Backalley\Wordpress\Fields\Contracts\DataFieldInterface;
use Backalley\FormFields\Contracts\FormFieldControllerInterface;
use Backalley\Wordpress\Fields\Contracts\FieldDataManagerInterface;

/**
 *
 */
abstract class AbstractFieldController implements DataFieldInterface, FormFieldControllerInterface
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
     * Callback function(s) to sanitize incoming data before saving to database
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Alerts to display upon validation failure
     *
     * @var array
     */
    protected $alerts = [];

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
    public function getFormField(): FormFieldInterface
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
    public function setFormField(FormFieldInterface $formField)
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
     * @param string $slug
     *
     * @return self
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get callback function(s) to sanitize incoming data before saving to database
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Set callback function(s) to sanitize incoming data before saving to database
     *
     * @param callable  $filters  Callback function(s) to sanitize incoming data before saving to database
     *
     * @return self
     */
    public function addFilter(callable $filter)
    {
        $this->filters[] = $filter;

        return $this;
    }

    /**
     * Get validation
     *
     * @return string
     */
    public function getRules(): array
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
    public function addRule($rule)
    {
        $this->rules[] = $rule;

        return $this;
    }

    /**
     * Get validation_messages
     *
     * @return string
     */
    public function getAlerts(): array
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
    public function setAlerts(array $alerts)
    {
        $this->alerts = $alerts;

        return $this;
    }

    /**
     *
     */
    protected function checkVar()
    {
        return filter_has_var(INPUT_POST, $this->formField->getName());
    }

    /**
     *
     */
    protected function getRawInput()
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
        if (empty($this->filters)) {
            $this->addFilter([$this, 'sanitizeDefault']);
        }

        foreach ($this->filters as $filter) {

            if (is_array($input)) {
                $input = array_filter($input, $filter);
            } else {
                $input = $filter($input);
            }
        }

        return $input;
    }

    /**
     *
     */
    public function saveInput($object)
    {
        if (true === $this->checkVar()) {
            exit(var_dump($this->getFilteredInput()));
            $this->dataManager->saveData($object, $this->getFilteredInput());
        }
    }

    /**
     *
     */
    protected function getData($object)
    {
        return $this->dataManager->getData($object);
    }

    /**
     *
     */
    protected function setFormFieldValue($object)
    {
        $this->formField->setValue($this->getData($object));

        return $this;
    }

    /**
     *
     */
    protected function sanitizeDefault($input)
    {
        return filter_var($input, FILTER_SANITIZE_STRING);
    }

    /**
     *
     */
    public function renderFormField($object)
    {
        return $this->setFormFieldValue($object)->formField;
    }

    /**
     * @todo actually implement it
     */
    protected function renderAlert($rule)
    {
        // do something
    }
}
