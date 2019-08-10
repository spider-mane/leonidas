<?php

namespace Backalley\Wordpress\Fields;

use Backalley\Wordpress\Fields\Contracts\FormSubmissionManagerInterface;
use Backalley\FormFields\Contracts\FormFieldControllerInterface;

class FormSubmissionGroup
{
    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var array
     */
    protected $callbacks = [];

    /**
     * @var array
     */
    private $hooks = [];

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
        foreach ($fields as $slug => $field) {
            $this->addField($slug, $field);
        }

        return $this;
    }

    /**
     *
     */
    public function addField(string $slug, FormFieldControllerInterface $field)
    {
        if (!in_array($slug, $this->fields)) {
            $this->fields[$slug] = $field;
        } else {
            throw new \Exception("This instance of " . __CLASS__ . " already has a field named {$slug}");
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
     * @param string $postType The post type to that is being saved
     */
    public function hook(string $postType)
    {
        $hook = "save_post_{$postType}";
        add_action($hook, [$this, '_savePost'], null, PHP_INT_MAX);

        $this->hooks[] = $hook;

        return $this;
    }

    /**
     *
     */
    public function _savePost($postId, $post, $update)
    {
        exit(var_dump($_REQUEST, $_SERVER, wp_get_referer()));
        $this->saveInput($post);
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

            if ($field->hasDataManager()) {
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
