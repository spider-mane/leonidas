<?php

namespace Backalley\Wordpress\Fields\Managers;

use Backalley\Form\Contracts\FieldDataManagerInterface;

class TermBasedPostMeta extends PostMetaFieldManager implements FieldDataManagerInterface
{
    /**
     *
     */
    protected $attribute;

    /**
     *
     */
    protected $taxonomy;

    /**
     *
     */
    protected $deleteButton;

    /**
     *
     */
    public function __construct($metaKey, $taxonomy, $attrubute)
    {
        $this->metaKey = $metaKey;
        $this->taxonomy = $taxonomy;
        $this->attribute = $attrubute;
    }

    /**
     * Get the value of attribute
     *
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Set the value of attribute
     *
     * @param mixed $attribute
     *
     * @return self
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get the value of term
     *
     * @return mixed
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Set the value of term
     *
     * @param mixed $term
     *
     * @return self
     */
    public function setTerm($term)
    {
        $this->term = $term;

        return $this;
    }

    /**
     * Get the value of deleteButton
     *
     * @return mixed
     */
    public function getDeleteButton()
    {
        return $this->deleteButton;
    }

    /**
     * Set the value of deleteButton
     *
     * @param mixed $deleteButton
     *
     * @return self
     */
    public function setDeleteButton($deleteButton)
    {
        $this->deleteButton = $deleteButton;

        return $this;
    }

    /**
     *
     */
    public function handleSubmittedData($post, $data): bool
    {
        $response = false;

        if (isset($this->deleteButton) && filter_has_var(INPUT_POST, $this->deleteButton)) {

            $this->deleteData($post);
            $response = true;
        } elseif (has_term($this->attribute, $this->taxonomy, $post->ID)) {

            $response = $this->getCurrentData($post, $data);
        }

        return $response;
    }

    /**
     *
     */
    protected function deleteData($post)
    {
        parent::deleteData($post);
        wp_remove_object_terms($post->ID, $this->attribute, $this->taxonomy);
    }
}
