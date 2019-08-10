<?php

namespace Backalley\Wordpress\Fields;

use Backalley\Wordpress\Fields\Contracts\FormSubmissionManagerInterface;
use Backalley\FormFields\Contracts\FormFieldControllerInterface;

trait FormSubmissionManagerTrait
{
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
     *
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

    /**
     *
     */
    public function saveInput($request): bool
    {
        $saved = false;

        /** @var FormFieldControllerInterface $field */
        foreach ($this->fields as $slug => $field) {

            $values[$slug] = $field->getFilteredInput();

            if ($field->hasDataManager() && !$field->getState('saved')) {
                $results[$slug]['saved'] = $field->saveInput($request);
                $results[$slug]['value'] = $values[$slug];
            }
        }

        foreach ($this->callbacks as $cb) {
            $cb($results ?? $values);
        }

        return $saved;
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
