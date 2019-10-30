<?php

namespace WebTheory\Leonidas\Forms\Controllers;

use WebTheory\Leonidas\Forms\Controllers\AbstractWpAdminFormSubmissionManager;

class PostMetaBoxFormSubmissionManager extends AbstractWpAdminFormSubmissionManager
{
    /**
     * @var WP_Post_Type
     */
    protected $postType;

    /**
     *
     */
    public function __construct(string $postType)
    {
        $this->postType = get_post_type_object($postType);
    }

    /**
     * Get the value of postType
     *
     * @return string
     */
    public function getPostType(): WP_Post_Type
    {
        return $this->postType;
    }

    /**
     *
     */
    public function hook()
    {
        add_action("save_post_{$this->postType->name}", [$this, 'savePostActionCallback'], null, 3);

        return parent::hook();
    }

    /**
     *
     */
    public function savePostActionCallback($postId, $post, $update)
    {
        if ($update && $this->isSafeToRun($post)) {
            $this->handleRequest($post);
        }
    }

    /**
     *
     */
    protected function isSafeToRun($post): bool
    {
        if (
            !$this->formHasValidNonce()
            || defined('DOING_AUTOSAVE') && DOING_AUTOSAVE
            || !current_user_can('edit_post', $post->ID)
        ) {
            return false;
        }

        return true;
    }
}
