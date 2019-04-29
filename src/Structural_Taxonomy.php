<?php

/**
 * @package Backalley-Core
 */

namespace Backalley;

class Structural_Taxonomy
{
    public $taxonomy;
    public $roles;
    public $roles_data;

    public static $post_var = 'backalley_hierarchy_role';
    public static $wp_option = 'ba_structural_term_roles';

    /**
     * role that signifies a term as being of the lowest possible ranking
     */
    public $baronesque;

    /**
     * role that signifies term is of the highest possible ranking
     */
    public $sovereign;

    public function __construct($taxonomy, $args = null)
    {
        // var_dump($args);
        $this->taxonomy = $taxonomy;
        $this->roles = $args['roles'];
        $this->sovereign = $args['top'];
        $this->baronesque = $args['bottom'];

        $this->set_roles_data();
        $this->init_option();

        // add_action('set_object_terms', [$this, 'enforce_stuctural_integrity'], null, 3);
    }

    /**
     * 
     */
    public function init_option()
    {
        new WP\Term_Option([
            'taxonomy' => $this->taxonomy,
            'display' => [$this, 'term_form_field'],
            'save' => [$this, 'update_term_roles']
        ]);
    }

    /**
     * 
     */
    public function term_form_field($taxonomy, $term)
    {
        $options = ['' => 'Select Role'];

        foreach ($this->roles_data as $role) {
            $options[$role['name']] = $role['title'];
        }

        $field = [
            'form_element' => 'select',
            'options' => $options,
            'selected' => !empty($term) ? $this::get_term_role($term->term_id, $taxonomy) : '',
            'attributes' => [
                'id' => 'backalley--hierarchy-role',
                'name' => 'backalley_hierarchy_role'
            ]
        ];

        $form_field = [
            'label' => 'Hierarchy Role',
            'description' => "Define a purpose for this term within the hierarcy",
            'field' => $field
        ];

        return $form_field;
    }

    /**
     * 
     */
    public function set_roles_data()
    {
        foreach ($this->roles as $new_role => $title) {

            $new_role_row = [
                'name' => sanitize_key($new_role),
                'title' => $title,
                'terms' => [],
                'taxonomy' => $this->taxonomy->name,
                'sovereign' => $new_role === $this->sovereign ? true : false,
                'baronesque' => $new_role === $this->baronesque ? true : false,
            ];

            $this->roles_data[] = $new_role_row;
        }
    }

    /**
     * 
     */
    public function update_term_roles($term_id, $tt_id)
    {
        $roles = get_option($this::$wp_option, []);
        $prev_role = $this::get_term_role($term_id, $this->taxonomy->name);
        $term_role = sanitize_text_field($_POST[$this::$post_var]);

        if ($prev_role === $term_role) {
            return;
        }

        foreach ($roles as &$role) {

            if ($prev_role === $role['name']) {
                $index = array_search($term_id, $role['terms']);
                unset($role['terms'][$index]);
            }

            if ($term_role === $role['name']) {
                $role['terms'][] = $term_id;
                $found = true;
            }
        }

        if (!isset($found)) {

            foreach ($this->roles_data as $new_row) {
                if ($new_row['name'] === $term_role) {

                    $new_row['terms'][] = $term_id;
                    $roles[] = $new_row;
                    break;
                }
            }
        }

        update_option($this::$wp_option, $roles, false);
    }

    /**
     * 
     */
    public static function get_term_role($term_id, $taxonomy)
    {
        $roles = get_option(Self::$wp_option, []);

        foreach ($roles as $role) {
            if ($role['taxonomy'] !== $taxonomy) {
                continue;
            }

            if (in_array($term_id, $role['terms'])) {
                $know_your_role = $role['name'];
                break;
            }
        }

        $shut_your_mouth = null;

        return $know_your_role ?? $shut_your_mouth;
    }

    /**
     * 
     */
    public static function get_role_terms($role, $taxonomy)
    {
        $roles = get_option(Self::$wp_option, []);

        foreach ($roles as $possible_role) {
            if ($possible_role['taxonomy'] !== $taxonomy) {
                continue;
            }

            if ($possible_role['name'] === $role) {
                $terms = $role['terms'];
            }
        }

        return $terms ?? null;
    }
}





    // /**
    //  * 
    //  */
    // public function enforce_stuctural_integrity($object_id, $tt_id, $taxonomy)
    // {
    //     if ($taxonomy !== $this->taxonomy->name) {
    //         return;
    //     }

    //     $term = get_term_by('term_taxonomy_id', $tt_id, $taxonomy, OBJECT)->term_id;

    //     if (get_term_meta($term, 'ba_structural_term', true)) {
    //         wp_remove_object_terms($object_id, $term, $taxonomy);
    //     }
    // }