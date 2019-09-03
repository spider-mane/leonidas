<?php

namespace Backalley\Wordpress\Fields\Managers;

use Backalley\Form\Managers\AbstractFieldDataManager;
use Backalley\Form\Contracts\FieldDataManagerInterface;

/**
 *
 */
class PostMetaFieldManager extends AbstractFieldDataManager implements FieldDataManagerInterface
{
    /**
     * @var string
     */
    protected $metaKey;

    /**
     * @var bool
     */
    protected $isUniqueValue = true;

    /**
     *
     */
    public function __construct($metaKey)
    {
        $this->metaKey = $metaKey;
    }

    /**
     * Get the value of metaKey
     *
     * @return string
     */
    public function getMetaKey(): string
    {
        return $this->metaKey;
    }

    /**
     * Get the value of isUniqueValue
     *
     * @return bool
     */
    public function isUniqueValue(): bool
    {
        return $this->isUniqueValue;
    }

    /**
     * Set the value of uniqueValue
     *
     * @param bool $isUniqueValue
     *
     * @return self
     */
    public function setIsUniqueValue(bool $isUniqueValue)
    {
        $this->isUniqueValue = $isUniqueValue;

        return $this;
    }

    /**
     *
     */
    public function createData($post, $data): bool
    {
        return add_post_meta($post->ID, $this->metaKey, $data, $this->isUniqueValue);
    }

    /**
     *
     */
    public function getCurrentData($post)
    {
        return get_post_meta($post->ID, $this->metaKey, $this->isUniqueValue);
    }

    /**
     *
     */
    public function handleSubmittedData($post, $data): bool
    {
        $response = (bool) update_post_meta($post->ID, $this->metaKey, $data, $this->getCurrentData($post));

        do_action("backalley/post/meta/updated/{$post->post_type}/{$this->metaKey}", $post, $data);

        return $response;
    }

    /**
     *
     */
    public function deleteData($post)
    {
        $response = (bool) delete_post_meta($post->id, $this->metaKey, $this->getCurrentData($post));

        do_action("backalley/post/meta/deleted/{$post->post_type}/{$this->metaKey}", $post);

        return $response;
    }
}
