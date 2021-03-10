<?php

namespace WebTheory\Leonidas\Library\Admin\Processing;

use Respect\Validation\Validatable;

abstract class AbstractInputManager
{
    /**
     * Validation rules
     *
     * @var Validatable[]
     */
    protected $rules = [];

    /**
     * Callback function(s) to sanitize incoming data
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Alerts to display upon validation failure
     *
     * @var array
     */
    protected $alerts = [];

    /**
     * @var array
     */
    protected $violations = [];

    /**
     * Get callback function(s) to sanitize incoming data before saving to database
     *
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * Set callback function(s) to sanitize incoming data before saving to database
     *
     * @param array $filters Callback function(s) to sanitize incoming data before saving to database
     *
     * @return self
     */
    public function setFilters(callable ...$filters)
    {
        $this->filters = $filters;

        return $this;
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
     *
     */
    public function getRule(string $rule): Validatable
    {
        return $this->rules[$rule];
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

            if (is_array($validator)) {
                $alert = $validator['alert'] ?? null;
                $validator = $validator['validator'];
            }

            $this->addRule($rule, $validator, $alert ?? null);
        }

        return $this;
    }

    /**
     * Add validation rule
     *
     * @param string $rule Name of the the rule being checked
     * @param Validatable $validator Validatable instance
     * @param string $alert Message to be displayed if validation fails
     *
     * @return self
     */
    public function addRule(string $rule, Validatable $validator, ?string $alert = null)
    {
        $this->rules[$rule] = $validator;

        if ($alert) {
            $this->addAlert($rule, $alert);
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
     *
     */
    public function getAlert(string $alert)
    {
        return $this->alerts[$alert];
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
     *
     */
    public function filterInput($input)
    {
        if (true === $this->validateInput($input)) {
            return $this->returnIfPassed($this->sanitizeInput($input));
        }

        return $this->returnIfFailed();
    }

    /**
     *
     */
    protected function validateInput($input)
    {
        $input = (array) $input;

        /** @var Validatable $validator */
        foreach ($this->rules as $rule => $validator) {
            foreach ($input as $value) {

                if (true !== $validator->validate($value)) {
                    $this->handleRuleViolation($rule);
                    return false;
                }
            }
        }

        return true;
    }

    /**
     *
     */
    protected function sanitizeInput($input)
    {
        $array = is_array($input); // check whether original input is an array
        $input = (array) $input; // cast input to array for simplicity

        foreach ($this->filters as $filter) {

            foreach ($input as &$value) {
                $value = $filter($value);
            }
            unset($value);
        }

        return $array ? $input : $input[0]; // return single item if original input was not an array
    }

    /**
     *
     */
    protected function returnIfPassed($input)
    {
        return $input;
    }

    /**
     *
     */
    protected function returnIfFailed()
    {
        return false;
    }

    /**
     *
     */
    protected function handleRuleViolation($rule)
    {
        $this->violations[$rule] = $this->alerts[$rule] ?? '';
    }

    /**
     * Get the value of violations
     *
     * @return array
     */
    public function getViolations(): array
    {
        return $this->violations;
    }

    /**
     *
     */
    public function clearViolations()
    {
        $this->violations = [];
    }
}
