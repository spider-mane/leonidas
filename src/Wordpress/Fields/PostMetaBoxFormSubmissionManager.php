<?php

namespace Backalley\Wordpress\Fields;

use Backalley\FormFields\Contracts\FormFieldControllerInterface;

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
    public function setPostType(string $postType)
    {
        $this->postType = $postType;

        return $this;
    }

    /**
     * @param string $postType The post type to that is being saved
     */
    public function hook()
    {
        add_action("save_post_{$this->postType}", [$this, '_savePost'], null, PHP_INT_MAX);

        return $this;
    }

    /**
     *
     */
    public function _savePost($postId, $post, $update)
    {
        $this->handleRequest($post);
    }
}
