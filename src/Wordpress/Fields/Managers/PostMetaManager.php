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
     * @var string`
     */
    protected $metaPrefix;

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
    public function getData($post)
    {
        return get_post_meta($post->ID, $this->getMetaKey(), true);
    }

    /**
     *
     */
    public function saveData($post, $data)
    {
        update_post_meta($post->ID, $this->metaKey, $data);

        do_action("backalley/updated/post/{$this->postType}/{$this->metaKey}", $post, $data);
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
