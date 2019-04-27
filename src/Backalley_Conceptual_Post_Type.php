<?php

/**
 *
 */

// namespace Backalley;

use Timber\Timber;

abstract class Backalley_Conceptual_Post_Type extends Conceptual_Post_Type_Core
{
    protected static $post_var = '';

    protected static $fieldsets = [];

    protected static $datasets = [];

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
        $fieldset['fields'] = Self::one_versus_many($fieldset['fields']);

        if (count($fieldset['fields']) === 1) {
            $columns = 3;
        }

        foreach (($fieldset['fields']) as $field => &$definition) {
            $attributes = $definition['attributes'] ?? [];

            $html = new Form_Element($definition);

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

    /**
     * 
     */
    protected static function one_versus_many($fields)
    {
        if (array_key_exists('form_element', $fields)) {
            return [$fields];
        }
        return $fields;
    }
}
