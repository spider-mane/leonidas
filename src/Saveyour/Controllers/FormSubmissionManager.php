<?php

namespace WebTheory\Saveyour\Controllers;

use WebTheory\Saveyour\Contracts\FormDataProcessorInterface;
use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\FormValidatorInterface;

class FormSubmissionManager
{
    /**
     * collection of FormFieldControllerInterface objects
     *
     * @var array
     */
    protected $fields = [];

    /**
     * collection of FormDataProcessorInterface objects
     *
     * @var array
     */
    protected $processors = [];

    /**
     * @var array
     */
    protected $validators = [];

    /**
     * Array of alerts to display in admin after form submission
     *
     * @var  array $alerts
     */
    private $alerts = [];

    /**
     *
     */
    public function __construct()
    {
        // do something maybe
    }

    /**
     * Get the value of validators
     *
     * @return mixed
     */
    public function getValidators()
    {
        return $this->validators;
    }

    /**
     *
     */
    public function addValidator(FormValidatorInterface $validator)
    {
        $this->validators[] = $validator;

        return $this;
    }

    /**
     * Get the value of fields
     *
     * @return mixed
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set the value of fields
     *
     * @param mixed $fields
     *
     * @return self
     */
    public function setFields($fields)
    {
        foreach ($fields as $field) {
            $this->addField($field);
        }

        return $this;
    }

    /**
     * @param FormFieldControllerInterface $field
     * @param string|array $groups
     */
    public function addField(FormFieldControllerInterface $field)
    {
        $name = $field->getFormFieldName();

        if (!in_array($name, $this->fields)) {
            $this->fields[$name] = $field;
        } else {
            throw new \Exception("This instance of " . __CLASS__ . " already has a field named {$name}");
        }

        return $this;
    }

    /**
     * Get the value of groups
     *
     * @return array
     */
    public function getGroups(): array
    {
        return $this->processors;
    }

    /**
     * Set the value of groups
     *
     * @param array $groups
     *
     * @return self
     */
    public function setGroups(array $groups)
    {
        foreach ($groups as $slug => $group) {
            $this->addGroup($slug, $group);
        }

        return $this;
    }

    /**
     * Add a group
     *
     * @param string $groups
     *
     * @return self
     */
    public function addGroup(string $slug, FormDataProcessorInterface $group)
    {
        if (!in_array($slug, $this->processors)) {
            $this->processors[$slug] = $group;
        } else {
            throw new \Exception("This instance of " . __CLASS__ . " already has a group named {$slug}");
        }

        return $this;
    }

    /**
     * Get $alerts
     *
     * @return array
     */
    protected function getAlerts(): array
    {
        return $this->alerts;
    }

    /**
     *
     */
    protected function isSafe(): bool
    {
        foreach ($this->validators as $validator) {
            if (!$validator->isValid()) {
                return false;
            }
        }

        return true;
    }

    /**
     *
     */
    public function handle($request = null)
    {
        if ($this->isSafe()) {
            return $this->handleRequest($request);
        }

        return false;
    }

    /**
     *
     */
    final protected function handleRequest($request)
    {
        /** @var FormFieldControllerInterface $field */
        foreach ($this->fields as $field) {

            if (!$field->postVarExists()) {
                continue;
            }

            if ($field->hasDataManager() && !$field->isSavingDisabled()) {
                $field->saveInput($request);
            } else {
                $field->getFilteredInput();
            }

            if (!empty($field->getStateParameter('violations'))) {
                $this->processFieldViolation($field);
            }
        }

        $this
            ->runProcessors($request)
            ->resetFieldsCache()
            ->finalizeRequest($request);
    }

    /**
     *
     */
    final private function runProcessors($request)
    {
        foreach ($this->processors as $processor) {
            $this->runProcessor($request, $processor);
        }

        return $this;
    }

    /**
     *
     */
    final private function runProcessor($request, FormDataProcessorInterface $processor)
    {
        $results = [];

        /** @var FormFieldControllerInterface $field */

        foreach ($processor->getFields() as $field) {

            $slug = $field->getFormFieldName();

            if ($field->postVarExists()) {
                $results[$slug]['value'] = $field->getFilteredInput();
            } else {
                $results[$slug]['value'] = null;
            }

            $results[$slug]['saved'] = $field->getStateParameter('save_successful');
        }

        $processor->run($request, $results);
    }

    /**
     *
     */
    final private function resetFieldsCache()
    {
        /** @var FormFieldControllerInterface $field */

        foreach ($this->fields as $field) {
            $field->resetStateCache('');
        }

        return $this;
    }

    /**
     *
     */
    public function processFieldViolation(FormFieldControllerInterface $field)
    {
        $alerts = $field->getAlerts();

        foreach ($field->getStateParameter('violations') as $violation) {
            $this->alerts[] = $alerts[$violation];
        }

        return $this;
    }

    /**
     *
     */
    protected function finalizeRequest($request)
    {
        return;
    }
}
