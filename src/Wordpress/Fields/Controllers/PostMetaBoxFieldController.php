<?php

namespace Backalley\WordPress\Fields\Controllers;

use Backalley\FormFields\Contracts\FormFieldInterface;
use Backalley\FormFields\Contracts\FormFieldControllerInterface;
use Backalley\Wordpress\Fields\Contracts\FieldDataManagerInterface;
use Backalley\Wordpress\Fields\Controllers\AbstractFieldController;

class PostMetaBoxFieldController extends AbstractFieldController implements FormFieldControllerInterface
{
    /**
     *
     */
    protected $postType;

    /**
     *
     */
    public function __construct($slug, string $postType, FormFieldInterface $formField, FieldDataManagerInterface $dataManager)
    {
        $this->postType = $postType;
        parent::__construct($slug, $formField, $dataManager);
    }

    /**
     * Get the value of postType
     *
     * @return mixed
     */
    public function getPostType()
    {
        return $this->postType;
    }

    /**
     * @param string $postType The post type to that is being saved
     */
    public function hook($postType = null)
    {
        add_action("save_post_{$this->postType}", [$this, '_savePost'], null, PHP_INT_MAX);

        return $this;
    }

    /**
     *
     */
    public function _savePost($postId, $post, $update)
    {
        $this->saveInput($post);
    }
}
