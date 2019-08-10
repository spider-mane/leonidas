<?php

namespace Backalley\Wordpress\Fields\Controllers;

use Respect\Validation\Validatable;
use Backalley\FormFields\Contracts\FormFieldInterface;
use Backalley\Wordpress\Fields\Contracts\DataFieldInterface;
use Backalley\FormFields\Contracts\FormFieldControllerInterface;
use Backalley\Wordpress\Fields\Contracts\FieldDataManagerInterface;
use Backalley\Wordpress\Fields\Contracts\FormSubmissionManagerInterface;

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
     * hasDataManager
     *
     * @var bool
     */
    private $hasDataManager = false;

    /**
     * @var string
     */
    protected $namePrefix = 'ba_';

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
     * @var array
     */
    private $stateCache = [
        'save_successful' => null,
        'save_attempted' => null,
        'input_value' => null,
    ];

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
    public function __construct($slug, FormFieldInterface $formField, ?FieldDataManagerInterface $dataManager = null)
    {
        $this->slug = $slug;
        $this->setformField($formField);

        if (isset($dataManager)) {
            $this->setDataManager($dataManager);
        }
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
        $this->hasDataManager = true;

        return $this;
    }

    /**
     * Get hasDataManager
     *
     * @return bool
     */
    public function hasDataManager(): bool
    {
        return $this->hasDataManager;
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
     * Get the value of namePrefix
     *
     * @return string
     */
    public function getNamePrefix(): string
    {
        return $this->namePrefix;
    }

    /**
     * Set the value of namePrefix
     *
     * @param string $namePrefix
     *
     * @return self
     */
    public function setNamePrefix(string $namePrefix)
    {
        $this->namePrefix = $namePrefix;

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
     * Add validation rules
     *
     * @param array $rules Array of Validatable instances
     *
     * @return self
     */
    public function addRules(array $rules)
    {
        foreach ($rules as $rule) {
            $this->addRule($rule);
        }

        return $this;
    }

    /**
     * Add validation rule
     *
     * @param Validatable $rule instance of Validatable interface
     *
     * @return self
     */
    public function addRule(Validatable $rule)
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
    protected function postVarExists()
    {
        return filter_has_var(INPUT_POST, $this->getFormFieldName());
    }

    /**
     *
     */
    protected function getRawInput()
    {
        return $_POST[$this->getFormFieldName()];
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
    public function getFilteredInput()
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
     * @param mixed $processed and packaged request data
     */
    public function saveInput($request): bool
    {
        $result = false;

        $this->stateCache['save_attempted'] = true;

        if (true === $this->postVarExists()) {
            $result = $this->dataManager->saveData($this->getFilteredInput(), ...$request);
            $this->stateCache['save_successful'] = $result;
        }

        return $result;
    }

    /**
     *
     */
    protected function getData($request)
    {
        return $this->dataManager->getData($request);
    }

    /**
     *
     */
    public function getFormFieldName()
    {
        return $this->namePrefix . $this->formField->getName();
    }

    /**
     *
     */
    protected function setFormFieldName()
    {
        $this->formField->setName($this->getFormFieldName());

        return $this;
    }

    /**
     *
     */
    public function setFormFieldValue($request)
    {
        $this->formField->setValue($this->getData($request));

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
    public function renderFormField($request)
    {
        if (!isset($this->displayCallback)) {
            return $this->_renderFormField($request);
        } else {
            $cb = $this->displayCallback;
            return $cb($request, $this->_renderFormField($request));
        }
    }

    /**
     * function to render the formfield if no callback is supplied
     */
    public function _renderFormField($request)
    {
        return $this
            ->prepareFormFieldForRendering($request)
            ->getFormField(); // $this->formField
    }

    /**
     *
     */
    protected function prepareFormFieldForRendering($request)
    {
        return $this
            ->setFormFieldValue($request)
            ->setFormFieldName();
    }

    /**
     * @todo actually implement it
     */
    protected function renderAlert($rule)
    {
        // do something
    }

    /**
     * Get the value of stateCache
     *
     * @return array
     */
    public function getStateCache(): array
    {
        return $this->stateCache;
    }

    /**
     * Get the value of stateCache
     *
     * @return array
     */
    public function getStateParameter(string $state)
    {
        return $this->stateCache[$state];
    }

    /**
     * Set the value of stateCache
     *
     * @param array $stateCache
     *
     * @return self
     */
    public function resetStateCache(string $nonce)
    {
        if (false) {
            throw new \Exeption("Invalid nonce provided");
            exit;
        }

        foreach ($this->stateCache as &$state) {
            $state = null;
        }
        unset($state);

        return $this;
    }
}
