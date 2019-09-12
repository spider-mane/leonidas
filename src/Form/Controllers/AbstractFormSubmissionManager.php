<?php

namespace Backalley\Form\Controllers;

use Backalley\Form\Contracts\FormFieldControllerInterface;
use Backalley\Form\Contracts\FormSubmissionGroupInterface;

abstract class AbstractFormSubmissionManager
{
    /**
     * collection of FormFieldControllerInterface objects
     *
     * @var array
     */
    protected $fields = [];

    /**
     * collection of FormSubmissionGroupInterface objects
     *
     * @var array
     */
    protected $groups = [];

    /**
     * @var array
     */
    protected $callbacks = [];

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
        return $this->groups;
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
    public function addGroup(string $slug, FormSubmissionGroupInterface $group)
    {
        if (!in_array($slug, $this->groups)) {
            $this->groups[$slug] = $group;
        } else {
            throw new \Exception("This instance of " . __CLASS__ . " already has a group named {$slug}");
        }

        return $this;
    }

    /**
     * Get the value of callbacks
     *
     * @return array
     */
    public function getCallbacks(): array
    {
        return $this->callbacks;
    }

    /**
     * Set the value of callbacks
     *
     * @param string $slug
     * @param string $group
     * @param callable $callback
     *
     * @return self
     */
    public function addCallBack(string $slug, callable $callback)
    {
        if (!isset($this->callbacks[$slug])) {
            $this->callbacks[$slug] = $callback;
        } else {
            throw new \Exception("This instance of " . __CLASS__ . " already has a callback named {$slug}");
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
            ->runGroups($request)
            ->resetFieldsCache()
            ->finalizeRequest($request);
    }

    /**
     *
     */
    final private function runGroups($request)
    {
        foreach ($this->groups as $group) {
            $this->runGroup($request, $group);
        }

        return $this;
    }

    /**
     *
     */
    final private function runGroup($request, FormSubmissionGroupInterface $group)
    {
        $values = [];

        /** @var FormFieldControllerInterface $field */

        foreach ($group->getFields() as $field) {

            $slug = $field->getFormFieldName();

            if ($field->postVarExists()) {
                $values[$slug] = $field->getStateParameter('input_value');
            } else {
                $values[$slug] = null;
            }

            // dynamically generate results array if field has a data manager
            // this allows callbacks to anticipate only input data where it is
            // not desired for the field to have any saving functionality
            if ($field->hasDataManager() && !$field->isSavingDisabled()) {
                $results[$slug]['saved'] = $field->getStateParameter('save_successful');
            }
        }

        if (isset($results)) {
            foreach ($results as $slug => &$result) {
                $result['value'] = $values[$slug];
            }
        }

        $group->run($request, $results);
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
    abstract protected function finalizeRequest($request);
}
