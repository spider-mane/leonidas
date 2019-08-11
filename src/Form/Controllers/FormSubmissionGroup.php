<?php

namespace Backalley\Form\Controllers;

use Backalley\Form\Contracts\FormFieldControllerInterface;

class FormSubmissionGroup
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
    public function setFields($fields): FormSubmissionGroup
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

    /**
     *
     */
    public function run($request)
    {
        $values = [];

        /** @var FormFieldControllerInterface $field */

        foreach ($this->fields as $field) {

            $slug = $field->getFormFieldName();

            if ($field->postVarExists()) {
                $values[$slug] = $field->getStateParameter('input_value');
            } else {
                $values[$slug] = null;
            }

            // dynamically generate results array if field has a data manager
            // this allows callbacks to anticipate only input data where it is
            // not desired for the field to have any saving functionality
            if ($field->hasDataManager()) {
                $results[$slug]['saved'] = $field->getStateParameter('save_successful');
            }
        }

        if (isset($results)) {
            foreach ($results as $slug => &$result) {
                $result['value'] = $values[$slug];
            }
        }

        foreach ($this->callbacks as $cb) {
            // send results to callback if it exists, otherwise send vales
            $cb($results ?? $values, $request);
        }
    }
}
