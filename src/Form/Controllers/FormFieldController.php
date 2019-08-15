<?php

namespace Backalley\Form\Controllers;

use Respect\Validation\Validatable;
use Backalley\Form\Contracts\DataFieldInterface;
use Backalley\Form\Contracts\FormFieldInterface;
use Backalley\Form\Contracts\FieldDataManagerInterface;
use Backalley\Form\Contracts\FormFieldControllerInterface;

/**
 *
 */
class FormFieldController implements DataFieldInterface, FormFieldControllerInterface
{
    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $postVar;

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
     * Callback to escape value on display
     *
     * @var callable|null
     */
    protected $escape = 'htmlspecialchars';

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
     * @var bool
     */
    private $savingDisabled = false;

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
     * @var array
     */
    private $stateCache = [
        'has_var' => null,
        'violations' => [],
        'input_value' => null,
        'save_attempted' => null,
        'save_successful' => null,
    ];

    /**
     *
     */
    public function __construct(string $slug, ?FormFieldInterface $formField = null, ?FieldDataManagerInterface $dataManager = null)
    {
        $this->slug = $slug;
        $this->postVar = $slug;

        if (isset($formField)) {
            $this->setformField($formField);
        }

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
     * Get the value of postVar
     *
     * @return string
     */
    public function getPostVar(): string
    {
        return $this->postVar;
    }

    /**
     * Set the value of postVar
     *
     * @param string $postVar
     *
     * @return self
     */
    public function setPostVar(string $postVar)
    {
        $this->postVar = $postVar;

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
    public function setRules(array $rules)
    {
        foreach ($rules as $rule => $validator) {
            $this->addRule($rule, $validator['validator'] ?? $validator, $validator['alert'] ?? null);
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
    public function addRule(string $rule, Validatable $validator, ?string $alert = null)
    {
        $this->rules[$rule] = $validator;

        if ($alert) {
            $this->alerts[$rule] = $alert;
        }

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
     * Set validation messages
     *
     * @param string  $alerts  validation_messages
     *
     * @return self
     */
    public function setAlerts(array $alerts)
    {
        foreach ($alerts as $rule => $alert) {
            $this->addAlert($rule, $alert);
        }

        return $this;
    }

    /**
     * Set validation_messages
     *
     * @param string  $alerts  validation_messages
     *
     * @return self
     */
    public function addAlert(string $rule, string $alert)
    {
        $this->alerts[$rule] = $alert;

        return $this;
    }

    /**
     * Get callback to escape value on display
     *
     * @return callable|null
     */
    public function getEscape()
    {
        return $this->escape;
    }

    /**
     * Set callback to escape value on display
     *
     * @param callable|null $escape Callback to escape value on display
     *
     * @return self
     */
    public function setEscape(?callable $escape = null)
    {
        $this->escape = $escape;

        return $this;
    }

    /**
     * Get the value of savingDisabled
     *
     * @return bool
     */
    public function isSavingDisabled(): bool
    {
        return $this->savingDisabled;
    }

    /**
     * Set the value of savingDisabled
     *
     * @param bool $savingDisabled
     *
     * @return self
     */
    public function setSavingDisabled(bool $savingDisabled)
    {
        $this->savingDisabled = $savingDisabled;

        return $this;
    }

    /**
     *
     */
    public function postVarExists()
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
        return $this->stateCache['input_value'] = $this->filterInput($this->getRawInput());
    }

    /**
     * @todo add validation logic
     */
    protected function validateInput($input)
    {
        /** @var Validatable $validator */
        foreach ($this->rules as $rule => $validator) {

            if (true !== $validator->validate($input)) {
                $this->stateCache['violations'][] = $rule;
                // $this->handleInvalidInput($input, $rule);
                return false;
            }
        }

        return true;
    }

    /**
     *
     */
    protected function handleInvalidInput($input, $rule)
    {
        return;
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
     * @param mixed
     */
    public function saveInput($request): bool
    {
        $result = false;

        $this->stateCache['save_attempted'] = true;

        return $this->stateCache['save_successful'] = $this->saveData($request);
    }

    /**
     *
     */
    public function saveData($request)
    {
        $filteredInput = $this->getStateParameter('input_value') ?? $this->getFilteredInput();

        return $this->dataManager->saveData($request, $filteredInput);
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
    public function getFormFieldName(): string
    {
        return $this->namePrefix . $this->formField->getName();
    }

    /**
     *
     */
    public function escapeValue($value)
    {
        return isset($this->escape)
            ? call_user_func($this->escape, $value)
            : $value;
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
        if ($this->hasDataManager()) {
            $this->formField->setValue($this->escapeValue($this->getData($request)));
        }

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
     * function to render the formfield if no callback is supplied
     */
    public function renderFormField($request)
    {
        return $this
            ->prepareFormFieldForRendering($request)
            ->getFormField();
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
        }

        foreach ($this->stateCache as &$state) {
            $state = null;
        }
        unset($state);

        return $this;
    }
}
