<?php

/**
 * @package Backalley-Core
 */

namespace Backalley;

class Saveyour
{
    public $instructions;
    public $sanitize_instructions;
    public $validate_instructions;
    public $save_instructions;

    /**
     * 
     */
    public function __construct($post_var, array $instructions)
    {
        $this->instructions = $instructions;

        $this->build_sanitize_array();
        $this->build_validate_array();
        $this->build_save_array();
    }

    /**
     * 
     */
    public function build_sanitize_array()
    {
        $sanitize = [];
        $validate = [];
        $save = [];

        foreach ($instructions as $var => $rules) {

            // create sanitize array to pass to filter_var_array()
            $filter = $rules['sanitize'];
            if (in_array($filter, filter_list())) {
                $sanitize[$var]['filter'] = $filter;
            } else {
                $sanitize[$var]['filter'] = FILTER_CALLBACK;
                $sanitize[$var]['options'] = $filter;
            }
        }
    }

    /**
     * 
     */
    public function build_validate_array()
    {
        //
    }

    /**
     * 
     */
    public function build_save_array()
    {
        //
    }

    /**
     * 
     */
    public function sanitize()
    {
        //
    }

    /**
     * 
     */
    public function validate()
    {
        //
    }

    /**
     * 
     */
    public function save_field()
    {
        //
    }

    /**
     * 
     */
    public function create_hook()
    {

    }

    /**
     * 
     */
    private function data_saver_api_example(...$args)
    {
        $instructions = [
            'post_var' => $post_id,

            'sanitize' => [] ?? '' ?? null, // callback function or method to sanitize the data
            'sanitize_args' => [] ?? '' ?? null, // array of arguments to pass to sanitize callback

            'validate' => [] ?? '' ?? null, // callback function or method to validate the data
            'validate_args' => [] ?? '' ?? null, // array of arguments to pass to validate callback

            'update' => [] ?? '', // callback function or method to save the data
            'update_args' => [] ?? '', // array of arguments to pass to save callback
        ];

        Data_Saver::save_field($field, $instructions);
    }
}
