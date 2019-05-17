<?php

namespace Backalley\DataFields;

use Backalley\Saveyour;
use Backalley\Backalley;
use Backalley\WP\MetaBox\PostMetaBoxFieldBaseTrait;


/**
 * @package Backalley
 */
class HoursFieldsetField extends FieldBase
{
    /**
     * name
     * 
     * @var string
     */
    public $name = 'hours';

    /**
     * title
     * 
     * @var string
     */
    public $title = 'Hours';

    /**
     * id
     * 
     * @var string
     */
    public $id = 'backalley--hours--fieldset';

    /**
     * id_prefix
     * 
     * @var string
     */
    public $id_prefix = 'backalley--hours--';

    /**
     * subnames
     * 
     * @var array
     */
    public $fields = [];

    use PostMetaBoxFieldBaseTrait;

    /**
     * 
     */
    public function __construct($args)
    {
        parent::__construct($args);
    }

    /**
     * 
     */
    public function render($post)
    {
        $post_id = $post->ID;

        $days = [
            'sunday' => [],
            'monday' => [],
            'tuesday' => [],
            'wednesday' => [],
            'thursday' => [],
            'friday' => [],
            'saturday' => [],
        ];

        foreach ($days as $day => &$hours) {
            $hours['title'] = ucwords($day);

            $hours['hours']['open'] = [];
            $hours['hours']['close'] = [];

            foreach ($hours['hours'] as $hour => &$attr) {
                $attr['value'] = get_post_meta($post_id, $this->meta_prefix . "{$post->post_type}_hours__{$day}_{$hour}", true);
                $attr['name'] = "$this->name[$day][$hour]";
            }
        }


        $fieldset['days'] = $days;

        Self::timber_render_fieldset($fieldset, 2);
    }

    /**
     * 
     */
    public function save($post_id, $post, $update)
    {
        $validate_cb = apply_filters("backalley/validate/location/hours", "sanitize_text_field");
        $sanitize_cb = apply_filters("backalley/sanitize/location/hours", "sanitize_text_field");

        foreach ($_POST[$this->name] as $day => $hours) {
            $day = sanitize_text_field($day);

            foreach ($hours as $hour => $time) {
                $hour = sanitize_text_field($hour);

                $meta_key = $this->meta_prefix . "{$post->post_type}_hours__{$day}_{$hour}";

                $sanitized_data = filter_var(
                    $time,
                    FILTER_CALLBACK,
                    ['options' => $sanitize_cb]
                );

                $old_data = get_post_meta($post_id, $meta_key, true);

                if ($old_data !== $sanitized_data && !add_post_meta($post_id, $meta_key, $sanitized_data, true)) {
                    update_post_meta($post_id, $meta_key, $sanitized_data, $old_data);
                }
            }
        }
    }
}