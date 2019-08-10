<?php

namespace Backalley\WordPress\Fields\Managers;

use Backalley\Wordpress\Fields\Contracts\FieldDataManagerInterface;
use Backalley\Wordpress\Fields\Contracts\DataFieldInterface;

/**
 *
 */
class PostMetaManager extends AbstractFieldDataManager implements FieldDataManagerInterface
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
     * @var string
     */
    protected $dataMap;

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
     * Get the value of dataMap
     *
     * @return array
     */
    public function getDataMap()
    {
        return $this->dataMap;
    }

    /**
     * Set the value of dataMap
     *
     * @param string $dataMap
     *
     * @return self
     */
    public function setDataMap(array $dataMap)
    {
        $this->dataMap = $dataMap;

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
    public function createData($data, $post)
    {
        return add_post_meta($post->ID, $this->metaKey, $data, $this->isUniqueValue);
    }

    /**
     *
     */
    public function getData($post)
    {
        return get_post_meta($post->ID, $this->getMetaKey(), $this->isUniqueValue);
    }

    /**
     *
     */
    public function saveData($data, $post): bool
    {
        return (bool) update_post_meta($post->ID, $this->metaKey, $data, $this->getData($post));

        // do_action("backalley/updated/post/{$this->postType}/{$this->metaKey}", $post, $data);
    }

    /**
     *
     */
    public function deleteData($post)
    {
        $response = delete_post_meta($post->id, $this->metaKey, '');

        // do_action("backalley/deleted/post/{$this->postType}/{$this->metaKey}", $post);

        return $response;
    }
}
