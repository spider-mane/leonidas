<?php

namespace Backalley\DataFields\Contracts;

interface PostMetaBoxFieldInterface
{
    /**
     * 
     */
    public function renderForPostMetaBox($post);

    /**
     * 
     */
    public function saveForPostMetaBox($post_id, $post, $update);
}