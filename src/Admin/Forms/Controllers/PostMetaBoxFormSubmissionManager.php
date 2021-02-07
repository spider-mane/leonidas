<?php

namespace WebTheory\Leonidas\Admin\Forms\Controllers;

use GuzzleHttp\Psr7\ServerRequest;
use WP_Post_Type;
use WebTheory\Leonidas\Admin\Forms\Controllers\AbstractWpAdminFormSubmissionManager;
use WebTheory\Leonidas\Admin\Forms\Validators\NoAutosaveValidator;
use WebTheory\Leonidas\Admin\Forms\Validators\Permissions\EditPost;
use WebTheory\Leonidas\Admin\Forms\Validators\WpNonceValidator;
use WebTheory\Leonidas\Core\Traits\HasNonceTrait;

class PostMetaBoxFormSubmissionManager extends AbstractWpAdminFormSubmissionManager
{
    use HasNonceTrait;

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
        $this->addDefaultFormValidators();

        $request = ServerRequest::fromGlobals()
            ->withAttribute('post', $post)
            ->withAttribute('post_id', $postId)
            ->withAttribute('update', $update);

        $this->process($request);
    }

    /**
     *
     */
    protected function addDefaultFormValidators()
    {
        $this->addValidator('no_autosave', new NoAutosaveValidator);
        $this->addValidator('user_cannot_edit', new EditPost);

        if (isset($this->nonce)) {
            $this->addValidator('invalid_request', new WpNonceValidator($this->nonce));
        }
    }
}
