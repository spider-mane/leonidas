<?php

namespace WebTheory\Leonidas\Forms\Controllers;

use GuzzleHttp\Psr7\ServerRequest;
use WP_Post_Type;
use WebTheory\Leonidas\Forms\Controllers\AbstractWpAdminFormSubmissionManager;

class PostMetaBoxFormSubmissionManager extends AbstractWpAdminFormSubmissionManager
{
    /**
     * @var WP_Post_Type
     */
    protected $postType;

    /**
     * {@inheritDoc}
     */
    protected const TRANSIENT__RULE_VIOLATION = 'leonidas.postMetaBox.field.ruleViolation';

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

            $request = ServerRequest::fromGlobals()
                ->withAttribute('post', $post)
                ->withAttribute('post_id', $postId)
                ->withAttribute('update', $update);

            $this->process($request);
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
