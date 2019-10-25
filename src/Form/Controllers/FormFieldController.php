<?php

namespace WebTheory\Saveyour\Controllers;

use WebTheory\Saveyour\Contracts\DataFieldInterface;
use WebTheory\Saveyour\Contracts\DataTransformerInterface;
use WebTheory\Saveyour\Contracts\FieldDataManagerInterface;
use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\FormFieldInterface;
use Respect\Validation\Validatable;

class FormFieldController implements DataFieldInterface, FormFieldControllerInterface
{
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
     * Callback to escape value on display
     *
     * @var DataTransformerInterface
     */
    protected $dataTransformer;

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
     * @var array
     */
    private $stateCache = [
        'violations' => [],
        'input_value' => null,
        'post_has_var' => null,
        'save_attempted' => null,
        'save_successful' => null,
    ];

    /**
     *
     */
    public function __construct(string $postVar, ?FormFieldInterface $formField = null, ?FieldDataManagerInterface $dataManager = null)
    {
        $this->setPostVar($postVar);

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
    public function setPostVar(string $postVar): FormFieldControllerInterface
    {
        $this->postVar = $postVar;

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
        $this->rules = [];

        foreach ($rules as $rule => $validator) {
            $this->addRule(
                $rule,
                $validator['validator'] ?? $validator['check'] ?? $validator,
                $validator['alert'] ?? null
            );
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
        if (!$this->stateCache['post_has_var']) {
            $this->stateCache['post_has_var'] = filter_has_var(INPUT_POST, $this->getPostVar());
        }

        return $this->stateCache['post_has_var'];
    }

    /**
     *
     */
    private function getRawInput()
    {
        return $_POST[$this->getPostVar()];
    }

    /**
     *
     */
    public function getFilteredInput()
    {
        if (!$this->stateCache['input_value']) {
            $this->stateCache['input_value'] = $this->filterInput($this->getRawInput());
        }

        return $this->stateCache['input_value'];
    }

    /**
     *
     */
    protected function filterInput($input)
    {
        if (true === $this->validateInput($input)) {
            return $this->sanitizeInput($input);
        } else {
            return false;
        }
    }

    /**
     *
     */
    protected function validateInput($input)
    {
        /** @var Validatable $validator */
        foreach ($this->rules as $rule => $validator) {

            if (true !== $validator->validate($input)) {
                $this->handleRuleViolation($rule);
                return false;
            }
        }

        return true;
    }

    /**
     *
     */
    protected function handleRuleViolation($rule)
    {
        $this->stateCache['violations'][] = $rule;
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

                foreach ($input as &$value) {
                    $value = $filter($value);
                }
                unset($value);
            } else {
                $input = $filter($input);
            }
        }

        return $input;
    }

    /**
     * @param mixed
     */
    public function saveInput($request)
    {
        $this->stateCache['save_attempted'] = true;
        $this->stateCache['save_successful'] = $this->saveData($request);
    }

    /**
     *
     */
    protected function saveData($request)
    {
        $filteredInput = $this->getFilteredInput();

        if (false !== $filteredInput) {
            return $this->dataManager->handleSubmittedData($request, $filteredInput);
        }

        return false;
    }

    /**
     *
     */
    protected function getData($request)
    {
        return $this->dataManager->getCurrentData($request);
    }

    /**
     *
     */
    public function getFormFieldName(): string
    {
        return $this->getPostVar();
    }

    /**
     *
     */
    protected function escapeValue($value)
    {
        $value =  isset($this->escape)
            ? !is_array($value)
            ? call_user_func($this->escape, $value)
            : array_filter($value, $this->escape)
            : $value;

        return $value;
    }

    /**
     *
     */
    protected function setFormFieldName()
    {
        $this->formField->setName($this->getPostVar());

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
    public function renderFormField($request): FormFieldInterface
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
     * @todo implement nonce layer to prevent unauthorized access to this
     * method
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
