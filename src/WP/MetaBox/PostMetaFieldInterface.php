<?php

namespace Backalley\WP\MetaBox;

interface PostMetaFieldInterface
{
    /**
     * 
     */
    public function set_post_meta_fields($fields);

    /**
     * 
     */
    public function render_post_meta_fields(\WP_Post $post, $meta_box);

    /**
     * 
     */
    public function save_post_meta_fields($post_id, $post, $update);
}