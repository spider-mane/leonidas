<?php

namespace WebTheory\Form\Groups;

use WebTheory\Form\Contracts\FormFieldControllerInterface;
use WebTheory\Form\Contracts\FormSubmissionGroupInterface;

class FormSubmissionGroupCallback implements FormSubmissionGroupInterface
{
    /**
     * @var string
     */
    protected $slug;

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var array
     */
    protected $callbacks = [];

    /**
     * Get the value of fields
     *
     * @return mixed
     */
    public function getFields(): array
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
        if (!in_array($slug, $this->callbacks)) {
            $this->callbacks[$slug] = $callback;
        } else {
            throw new \Exception("This instance of " . __CLASS__ . " already has a callback named {$slug}");
        }

        return $this;
    }
}
