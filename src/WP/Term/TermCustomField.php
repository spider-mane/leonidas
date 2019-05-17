<?php

namespace Backalley\WP\Term;

use Backalley\FormFields\FormField;
use Backalley\Html\HtmlConstructor;
use Backalley\DataFields\FieldManager;


/**
 * @package Backalley-Core
 */
class TermCustomField
{
    /**
     * The taxonomy to apply the field
     * 
     * @var string
     */
    public $taxonomy;

    /**
     * Callback function to run to display the field
     * 
     * @var string
     */
    public $add_term_form_field_callback;

    /**
     * Callback function to run to display the field
     * 
     * @var string
     */
    public $edit_term_form_field_callback;

    /**
     * Callback function to run to save field data
     * 
     * @var string
     */
    public $save_term_callback;

    /**
     * Custom field 
     * 
     * @var string
     */
    public $field;

    /**
     * Html name or POST query variable assigned to the field 
     * 
     * @var string
     */
    public $name;

    /**
     * 
     */
    public function __construct($args)
    {
        $this->taxonomy = $args['taxonomy'];

        if (isset($args['field'])) {
            $this->set_field($args['field']);
        }

        $this->add_term_form_field_callback = $args['add_term_cb'] ?? [$this->field, 'render_add_term_form_field'];
        $this->edit_term_form_field_callback = $args['edit_term_cb'] ?? [$this->field, 'render_edit_term_form_field'];
        $this->save_term_callback = $args['save_term_cb'] ?? [$this->field, 'save_term_field'];

        $this->hook();
    }

    /**
     * 
     */
    public function hook()
    {
        // display
        add_action("{$this->taxonomy->name}_edit_form_fields", $this->edit_term_form_field_callback, null, 2);
        add_action("{$this->taxonomy->name}_add_form_fields", $this->add_term_form_field_callback, null, 2);

        // save
        add_action("edited_{$this->taxonomy->name}", $this->save_term_callback, null, 2);
        add_action("create_{$this->taxonomy->name}", $this->save_term_callback, null, 2);
    }

    /**
     * 
     */
    public function set_field($field)
    {
        $field['context'] = 'term';
        $this->field = FieldManager::create($field);
    }

    /**
     * 
     */
    public function bulk_add($fields)
    {
        foreach ($fields as $field) {
            $field = new TermCustomField($field);
        }
    }
}
