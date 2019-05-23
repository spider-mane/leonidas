<?php

namespace Backalley\WordPress\MetaBox;

use Backalley\GuctilityBelt;


/**
 * 
 */
trait PostMetaFieldManagerTrait
{
    /**
     * 
     */
    public $post_meta_fields = [];

    /**
     * Instantiate and return array of fields
     */
    public function set_post_meta_fields($fields)
    {
        foreach ($fields as $field => &$args) {
            $args['context'] = 'post_meta_box';
            $field = GuctilityBelt::arg_to_class($args['field'], "%sField", "Backalley\\WordPress\\Fields");

            $this->post_meta_fields[$field] = new $field($args);
        }

        // die(var_dump($this->post_meta_fields));
        return $this;
    }

    /**
     * Display fields
     */
    public function render_post_meta_fields($post, $meta_box)
    {
        $i = count($this->post_meta_fields);

        foreach ($this->post_meta_fields as $field) {
            $i--;

            $field->render($post);

            do_action("backalley/{$post->post_type}/meta_box/{$this->id}/{$field->name}", $post, $meta_box);

            echo '<br>';

            if ($i > 0) {
                echo '<hr>';
            }
        }
    }

    /**
     * Save data entered into post meta form fields
     */
    public function save_post_meta_fields($post_id, $post, $update)
    {
        foreach ($this->post_meta_fields as $field) {

            if (filter_has_var(INPUT_POST, $field->name) && is_callable([$field, 'save'])) {
                $field->save($post_id, $post, $update);
            }

            do_action("backalley/{$post->post_type}/save/{$field->name}", $post_id, $post, $update);
        }
    }
}
