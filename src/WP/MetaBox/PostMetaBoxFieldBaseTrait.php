<?php

namespace Backalley\WP\MetaBox;

use Timber\Timber;
use Backalley\Saveyour;
use Backalley\Backalley;
use Backalley\GuctilityBelt;
use Backalley\FormFields\FormField;

trait PostMetaBoxFieldBaseTrait
{
    // public $width = 'large-text';

    /**
     *
     */
    public static function timber_render_fieldset($content, $columns = 1, $action = 'render', $title = true)
    {
        Timber::$locations = Backalley::$timber_locations;

        switch ($columns) {
            case 2:
                Timber::$action('fieldset__title--two-column.twig', $content);
                break;
            case 3:
                Timber::$action('fieldset__title--one-column2.twig', $content);
                break;
            default:
                Timber::$action('fieldset__title--one-column.twig', $content);
        }
    }

    /**
     * 
     */
    public static function metabox_fieldset_template($fieldset, $columns = 1, $action = 'render', $title = true)
    {
        $fieldset['fields'] = GuctilityBelt::one_versus_many('form_element', $fieldset['fields']);

        if (count($fieldset['fields']) === 1) {
            $columns = 3;
        }

        foreach (($fieldset['fields']) as $field => &$definition) {
            $attributes = $definition['attributes'] ?? [];

            $definition = [
                'title' => $definition['title'] ?? '',
                'id' => $attributes['id'] ?? '',
                'field' => FormField::create($definition),
                'hidden' => $definition['hidden'] ?? null,
                'submit_button' => $definition['submit_button'] ?? null,
                'wp_submit_button' => $definition['wp_submit_button'] ?? null
            ];

            unset($definition);
        }

        Self::timber_render_fieldset($fieldset, $columns, $action, $title);
    }

    /**
     * 
     */
    public function get_data($post)
    {
        if (!empty($callback = $this->get_data_cb)) {
            return $callback($post, $this);
        }

        return get_post_meta($post->ID, $this->meta_prefix . "{$post->post_type}_{$this->meta_key}", true);
    }

    /**
     * 
     */
    public function save_data($post, $saveyour)
    {
        if (!empty($callback = $this->save_data_cb)) {
            $callback($post, $this, $saveyour);
            return;
        }

        $saveyour->save();
    }

    /**
     * 
     */
    public function save($post_id, $post, $update)
    {
        $instructions = [
            'filter' => !empty($this->filter) ? $this->filter : 'sanitize_text_field',
            'check' => !empty($this->validation) ? $this->validation : null,
            'type' => 'post_meta',
            'item' => $post_id,
            'save' => "{$this->meta_prefix}{$post->post_type}_{$this->meta_key}"
        ];

        $results = Saveyour::judge($instructions, $_POST[$this->name]);
    }
}