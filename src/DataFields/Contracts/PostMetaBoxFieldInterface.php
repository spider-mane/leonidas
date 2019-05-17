<?php

namespace Backalley\DataFields\Contracts;

interface PostMetaBoxFieldInterface
{
    /**
     * 
     */
    public function renderPostMetaBoxField($post);

    /**
     * 
     */
    public function savePostMetaBoxField($post_id, $post, $update);
}