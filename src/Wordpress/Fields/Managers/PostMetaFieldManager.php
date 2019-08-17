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
     * @var string
     */
    protected $prefix = 'ba_';

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var bool
     */
    protected $isUniqueValue = true;

    /**
     * @var bool
     */
    protected $isSerialized = false;

    /**
     * @var string
     */
    protected $serializedAs;

    /**
     * @var string|int Index where seriazed data is to be found
     */
    protected $serializationIndex;

    /**
     *
     */
    protected $primaryKey = 'ID';

    /**
     *
     */
    public function __construct($metaKey, $postType = null)
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
     * Get the value of prefix
     *
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * Set the value of prefix
     *
     * @param string $prefix
     *
     * @return self
     */
    public function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;

        return $this;
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
     * Get the value of isSerialized
     *
     * @return bool
     */
    public function isSerialized(): bool
    {
        return $this->isSerialized;
    }

    /**
     * Set the value of isSerialized
     *
     * @param bool $isSerialized
     *
     * @return self
     */
    public function setIsSerialized(bool $isSerialized)
    {
        $this->isSerialized = $isSerialized;

        return $this;
    }

    /**
     * Get the value of serializedAs
     *
     * @return string
     */
    public function getSerializedAs(): string
    {
        return $this->serializedAs;
    }

    /**
     * Set the value of serializedAs
     *
     * @param string $serializedAs
     *
     * @return self
     */
    public function setSerializedAs(string $serializedAs)
    {
        $this->serializedAs = $serializedAs;

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
    public function getData($post)
    {
        return get_post_meta($post->ID, $this->metaKey, $this->isUniqueValue);
    }

    /**
     *
     */
    public function saveData($post, $data): bool
    {
        $response = (bool) update_post_meta($post->ID, $this->metaKey, $data, $this->getData($post));

        do_action("backalley/updated/post/{$post->post_type}/{$this->metaKey}", $post, $data);

        return $response;
    }

    /**
     *
     */
    public function deleteData($post)
    {
        $response = (bool) delete_post_meta($post->id, $this->metaKey, '');

        do_action("backalley/deleted/post/{$post->post_type}/{$this->metaKey}", $post);

        return $response;
    }
}
