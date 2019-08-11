<?php

namespace Backalley\Wordpress\Forms\Controllers;

use Backalley\Form\Controllers\AbstractFormSubmissionManager;

class PostMetaBoxFormSubmissionManager extends AbstractFormSubmissionManager
{
    /**
     * @var string
     */
    protected $postType;

    /**
     *
     */
    public function __construct($postType)
    {
        $this->postType = $postType;
    }

    /**
     * Get the value of postType
     *
     * @return string
     */
    public function getPostType(): string
    {
        return $this->postType;
    }

    /**
     * Set the value of postType
     *
     * @param string $postType
     *
     * @return self
     */
    protected function setPostType(string $postType)
    {
        $this->postType = $postType;

        return $this;
    }

    /**
     * @param string $postType The post type to that is being saved
     */
    public function hook()
    {
        add_action("save_post_{$this->postType}", [$this, '_handleRequest'], null, PHP_INT_MAX);

        return $this;
    }

    /**
     *
     */
    public function _handleRequest($postId, $post, $update)
    {
        if (!$update) {
            return;
        }

        $this->handleRequest($post);
    }
}
