<?php

namespace Backalley\Wordpress\Fields;

use Backalley\FormFields\Contracts\FormFieldControllerInterface;

abstract class AbstractFormSubmissionManager
{
    /**
     *
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
        //
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
    public function addField(FormFieldControllerInterface $field, $groups = null)
    {
        $name = $field->getFormFieldName();

        if (!in_array($name, $this->fields)) {
            $this->fields[$name] = $field;
        } else {
            throw new \Exception("This instance of " . __CLASS__ . " already has a field named {$name}");
        }

        foreach ((array) $groups as $group) {
            $this->addFieldToGroup($name, $group);
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
        foreach ($groups as $group) {
            $this->addGroup($group);
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
    public function addGroup(string $group)
    {
        if (!in_array($group, $this->groups)) {
            $this->groups[$group] = [];
        } else {
            throw new \Exception("This instance of " . __CLASS__ . " already has a group named {$group}");
        }

        return $this;
    }

    /**
     * addFieldToGroup
     *
     * @param string $field The slug of the field to add to the group
     * @param string $group The slug of the group to append field to
     */
    public function addFieldToGroup(string $field, string $group)
    {
        $this->groups[$group]['fields'] = $field;

        return $this;
    }

    /**
     * addFieldToGroup
     *
     * @param string $callback The slug of the callback to add to the group
     * @param string $group The slug of the group to append field to
     */
    public function assignCallbackToGroup(string $callback, string $group)
    {
        $this->groups[$group]['callbacks'] = $callback;

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
    public function addCallBack(string $slug, ?string $group, callable $callback)
    {
        $this->callbacks[$slug] = $callback;

        if (isset($group)) {
            $this->assignCallbackToGroup($slug, $group);
        }

        return $this;
    }

    /**
     *
     */
    public function handleRequest(...$request)
    {
        /** @var FormFieldControllerInterface $field */
        foreach ($this->fields as $slug => $field) {

            $values[$slug] = $field->getFilteredInput();

            if ($field->hasDataManager()) {
                $results[$slug]['saved'] = $field->saveInput($request);
                $results[$slug]['value'] = $values[$slug];
            }
        }

        foreach ($this->callbacks as $cb) {
            $cb($results ?? $values);
        }

        foreach ($this->groups as $group) {
            $group->run();
        }
    }

    /**
     *
     */
    public function getFilteredInput()
    {
        $input = [];

        /** @var FormFieldControllerInterface $field */
        foreach ($this->fields as $slug => $field) {
            $input[$slug] = $field->getFilteredInput();
        }

        return $input;
    }
}
