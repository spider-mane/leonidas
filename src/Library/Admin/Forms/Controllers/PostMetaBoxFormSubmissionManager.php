<?php

namespace Leonidas\Library\Admin\Forms\Controllers;

use GuzzleHttp\Psr7\ServerRequest;
use WP_Post_Type;
use Leonidas\Library\Admin\Forms\Controllers\AbstractWpAdminFormSubmissionManager;
use Leonidas\Library\Admin\Forms\Validators\NoAutosaveValidator;
use Leonidas\Library\Admin\Forms\Validators\Permissions\EditPost;
use Leonidas\Library\Admin\Forms\Validators\WpNonceValidator;
use Leonidas\Traits\MaybeHandlesCsrfTrait;

class PostMetaboxFormSubmissionManager extends AbstractWpAdminFormSubmissionManager
{
    use MaybeHandlesCsrfTrait;

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
        $this->addValidator('no_autosave', new NoAutosaveValidator());
        $this->addValidator('user_cannot_edit', new EditPost());

        if (isset($this->csrfManager)) {
            $this->addValidator('invalid_request', new WpNonceValidator($this->csrfManager));
        }
    }
}
