<?php

namespace Backalley\WordPress\MetaBox;

use Backalley\WordPress\MetaBox;

class Builder
{
    /**
     * @var MetaboxInterface
     */
    protected static $metabox = MetaBox::class;

    /**
     * Instantiate multiple MetaBoxes
     */
    public function create(array $meta_boxes) : array
    {
        foreach ($meta_boxes as $name => $meta_box) {

            if (!isset($meta_box['id'])) {
                $meta_box['id'] = $name;
            }

            $meta_boxes[$name] = (new static::$metabox($meta_box))
                ->setContext($args['context']);
        }

        return $meta_boxes;
    }

    /**
     *
     */
    public static function setMetabox(MetaBoxInterface $class)
    {
        static::$metabox = $class;
    }
}
