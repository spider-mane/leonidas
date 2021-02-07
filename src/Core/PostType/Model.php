<?php

namespace WebTheory\Leonidas\Core\PostType;

use Exception;
use WebTheory\GuctilityBelt\TxtCase;

class Model
{
    /**
     *
     */
    protected $id;

    /**
     *
     */
    public const META_KEY_MAP = [];

    /**
     *
     */
    public const COLUMNS = [];

    /**
     *
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     *
     */
    public function __call($name, $args)
    {
        $name = TxtCase::snake($name);

        if (isset(static::META_KEY_MAP[$name])) {
            return $this->get($name);
        }

        throw new Exception('no such thing!');
    }

    /**
     *
     */
    public function get($key)
    {
        return get_post_meta($this->id, static::META_KEY_MAP[$key], true);
    }
}
