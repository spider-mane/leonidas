<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\WordPress;

class Post
{
    public static function save_fields(array $fields)
    {
        foreach ($fields as $field => $instructions) {
            $results[$field] = new Saveyour($field);

        }
    }

    private static function save_fields_api_example(...$args)
    {
        $sanitized_data = [
            'post_id' => $post_id,

            'publication' => [
                'sanitize' => 'sanitize_text_field',
                'sanitize_args' => [],

                'validate' => '',
                'validate_args' => [],

                'update' => 'update_post_meta',
                'update_args' => [
                    // dependent on function called to store
                ],
                // if update and update_args ommited, update_post_meta args can be supplied at this level as
                // update_post_meta will be the default callback to store data
                'post_id' => '', // can be used to override post_id specified at array root
                'meta_key' => "", // required
                ''

            ],
            'date_published' => [
                'sanitize' => 'sanitize_text_field',
                'validate' => '',
                'update' => [
                    'callback' => '',
                    'args' => []
                ],
                'update_args' => []
            ],
            'author' => [
                'sanitize' => 'sanitize_text_field',
                'validate' => '',
                'update' => [
                    'callback' => '',
                    'args' => []
                ],
                'update_args' => []
            ],
        ];

        Backalley_Post::save_fields($raw_data, $sanitized_data);
    }
}
