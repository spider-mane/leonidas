<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\Saveyour;

use Respect\Validation\Validator as v;

class Saveyour
{
    /**
     * array of fields to save
     *
     * @var array
     */
    public $flock;

    /**
     * array of user set rules
     *
     * @var array
     */
    public $scriptures;

    /**
     * Fields that passed validation
     *
     * @var array
     */
    public $saints = [];

    /**
     * Fields that failed validation
     *
     * @var array
     */
    public $sinners = [];

    /**
     * Array of sanitized values and the results of saving
     *
     * @var array
     */
    public $revelations = [];

    /**
     *
     */
    public function validate()
    {
        foreach ($this->scriptures as $field => $instructions) {
            if (empty($this->flock[$field])) {
                $this->saints[] = $field;
            }

            $validation = $instructions['check'] ?? null;

            switch (!isset($validation) || v::$validation()->validate($this->flock[$field])) {
                case true:
                    $this->saints[] = $field;
                    break;

                case false:
                    $this->sinners[] = $field;
                    break;
            }
        }

        return $this;
    }

    /**
     * Sanitize fields that passed validation for entry into database
     */
    public function sanitize()
    {
        foreach ($this->saints as $field) {
            $sanitizer = $this->scriptures[$field]['filter'] ?? "sanitize_text_field";

            $this->revelations[$field]['value'] = $this->flock[$field] = $sanitizer($this->flock[$field]);
        }

        return $this;
    }

    /**
     *
     */
    public function save()
    {
        foreach ($this->saints as $field) {
            $method = $this->scriptures[$field]['type'];

            $db_row = $this->scriptures[$field]['item'];
            $db_field = $this->scriptures[$field]['save'];
            $data = $this->flock[$field];

            $result = Saveyour\Save::$method($db_row, $db_field, $data);

            $this->revelations[$field]['updated'] = $result['updated'];
            $this->revelations[$field]['success'] = $result['success'];
        }
        // die(var_dump($this->salvation));

        // exit;
        return $this;
    }

    /**
     *
     */
    public function get_sinners()
    {
        return $this->sinners;
    }

    /**
     *
     */
    public static function judge($instructions, $data)
    {
        $judgement = new Saveyour;
        $judgement->flock = is_array($data) ? $data : [$data];
        $judgement->scriptures = is_array($data) ? $instructions : [$instructions];
        $judgement->validate()->sanitize()->save();

        return $judgement;
    }

    // /**
    //  *
    //  */
    // public static function judge_this($instructions, $data)
    // {
    //     $judgement = new Saveyour;
    //     $judgement->flock = [$data];
    //     $judgement->scriptures = [$instructions];
    //     $judgement->validate()->sanitize()->save();

    //     return $judgement;
    // }

    /**
     *
     */
    public static function pass_judgement($instructions, $data)
    {
        $judgement = new Saveyour;
        $judgement->flock = $data;
        $judgement->scriptures = $instructions;
        $judgement->validate()->sanitize();

        return $judgement;
    }

    /**
     *
     */
    private function data_saver_api_example(...$args)
    {
        /**
         * $field key names must match the key in the array where the data c
         */
        $fields = [
            'email' => [
                'filter' => 'email', // defines both sanitize and validate methods
                'type' => 'post_meta', // defines what is being saved ie table
                'item' => $post_id, // defines the column to save the data
                'save' => 'contact_info__email', // defines exact field to save data

                /**
                 * optional args
                 */
                'sanitize' => 'email', // define sanitization method
                'validate' => 'email', // define validation method

                /**
                 * more specific optional args
                 */
                'sanitize_cb' => [] ?? '', // callback function or method to sanitize the data
                'sanitize_args' => [] ?? '', // array of arguments to pass to sanitize callback

                'validate_cb' => [] ?? '', // callback function or method to validate the data
                'validate_args' => [] ?? '', // array of arguments to pass to validate callback

                'save_cb' => [] ?? '', // callback function or method to save the data
                'save_args' => [] ?? '', // array of arguments to pass to save callback
            ],

            'phone' => [
                'process' => 'phone-us',
                'save' => 'post_meta',
            ]
        ];

        Saveyour::judge($fields, $data);
    }
}
