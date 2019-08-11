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
    public function handleRequest($request)
    {
        $values = [];

        /** @var FormFieldControllerInterface $field */

        foreach ($this->fields as $slug => $field) {

            if ($field->postVarExists()) {
                $values[$slug] = $field->getFilteredInput();
            } else {
                $values[$slug] = null;
            }

            // dynamically generate results array if field has a data manager
            // this allows callbacks to anticipate only input data where it is
            // not desired for the field to have any saving functionality
            if ($field->hasDataManager()) {
                $results[$slug]['saved'] = $field->saveInput($request);
            }
        }

        if (isset($results)) {
            foreach ($results as $slug => &$result) {
                $result['value'] = $values[$slug];
            }
        }

        foreach ($this->callbacks as $cb) {
            $cb($results ?? $values, $request);
        }

        /** @var FormSubmissionGroup $group */
        foreach ($this->groups as $group) {
            $group->run($request);
        }

        /** @var FormFieldControllerInterface $field */
        foreach ($this->fields as $field) {
            $field->resetStateCache('');
        }
    }
}
