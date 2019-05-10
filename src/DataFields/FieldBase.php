<?php

namespace Backalley\DataFields;

use Timber\Timber;
use Backalley\Backalley;
use Backalley\FormFields\FormField;
use Backalley\GuctilityBelt;

abstract class FieldBase
{
    /**
     * name
     * 
     * @var string
     */
    public $name = '';

    /**
     * title
     * 
     * @var string
     */
    public $title = '';

    /**
     * id
     * 
     * @var string
     */
    public $id = '';

    /**
     * attributes
     * 
     * @var string
     */
    public $attributes = [];

    /**
     * id_prefix
     * 
     * @var string
     */
    public $id_prefix = '';

    /**
     * width
     * 
     * @var string
     */
    public $width = 'large-text';

    /**
     * meta_key
     * 
     * @var string
     */
    public $meta_key = '';

    /**
     * meta_prefix
     * 
     * @var string
     */
    public $meta_prefix = '';

    /**
     * filter
     * 
     * @var string
     */
    public $filter = 'sanitize_text_field';

    /**
     * validation
     * 
     * @var string
     */
    public $validation = '';

    /**
     * 
     */
    public function __construct($args)
    {
        $this->name = $args['name'] ?? $this->name;
        $this->title = $args['title'] ?? $this->title;
        $this->width = $args['width'] ?? $this->width;
        $this->filter = $args['sanitize'] ?? $this->filter;
        $this->meta_key = $args['meta_key'] ?? $args['name'];
        $this->id_prefix = $args['id_prefix'] ?? $this->id_prefix;
        $this->validation = $args['validate'] ?? $this->validation;
        $this->attributes = $args['attributes'] ?? $this->attributes;
        $this->id = $args['id'] ?? "{$this->id_prefix}{$this->name}";
        $this->meta_prefix = $args['meta_prefix'] ?? Backalley::$meta_key_prefix;
    }

    /**
     * 
     */
    abstract public function render($post);

    /**
     * 
     */
    public function save($post_id, $post, $update, $fieldset = null, $raw_data = null)
    {
        $meta_key = "{$this->meta_prefix}{$post->post_type}_{$this->meta_key}";
        $old_value = get_post_meta($post_id, $meta_key, true);

        $directions = [
            ''
        ];

        $filter = $this->filter;

        $new_value = $filter($raw_data);

        if ($new_value !== $old_value) {
            update_post_meta($post->ID, $meta_key, $new_value);
        }
    }

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
    public static function generate_fieldset($fieldset, $columns = 1, $action = 'render', $title = true)
    {
        $fieldset['fields'] = GuctilityBelt::one_versus_many('form_element', $fieldset['fields']);

        if (count($fieldset['fields']) === 1) {
            $columns = 3;
        }

        foreach (($fieldset['fields']) as $field => &$definition) {
            $attributes = $definition['attributes'] ?? [];

            $html = new FormField($definition);

            $definition = [
                'title' => $definition['title'] ?? '',
                'id' => $attributes['id'] ?? '',
                'field' => $html->html,
                'hidden' => $definition['hidden'] ?? null,
                'submit_button' => $definition['submit_button'] ?? null,
                'wp_submit_button' => $definition['wp_submit_button'] ?? null
            ];

            unset($definition);
        }

        Self::timber_render_fieldset($fieldset, $columns, $action, $title);
    }
}