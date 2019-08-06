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
    protected $metaPrefix;

    /**
     * @var bool
     */
    protected $uniqueValue = true;

    /**
     *
     */
    public function __construct($metaKey)
    {
        $this->metaKey = $metaKey;
    }

    /**
     *
     */
    public function createData($post, $data)
    {
        return add_post_meta($post->ID, $this->metaKey, $data, $this->uniqueValue);
    }

    /**
     *
     */
    public function getData($post)
    {
        return get_post_meta($post->ID, $this->getMetaKey(), $this->uniqueValue);
    }

    /**
     *
     */
    public function saveData($post, $data)
    {
        $response = update_post_meta($post->ID, $this->metaKey, $data);

        // do_action("backalley/updated/post/{$this->postType}/{$this->metaKey}", $post, $data);

        return $response;
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

    /**
     * Get the value of metaKey
     *
     * @return string
     */
    public function getMetaKey(): string
    {
        return $this->metaKey;
    }
}
