<?php

namespace Backalley\Form\Controllers;

use Backalley\Form\Contracts\FormFieldControllerInterface;

abstract class AbstractFormSubmissionManager
{
    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var array
     */
    protected $groups = [];

    /**
     * @var array
     */
    protected $callbacks = [];

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
    public function addGroup(string $slug, FormSubmissionGroup $group)
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
        /** @var FormSubmissionGroup $group */

        foreach ($this->groups as $group) {
            $group->run($request);
        }

        return $this;
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
    abstract function finalizeRequest($request);
}
