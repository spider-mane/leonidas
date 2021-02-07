<?php

namespace WebTheory\Leonidas\Core\Util;

abstract class AbstractWpObjectCollection
{
    /**
     *
     */
    protected const ID_KEY = '';

    /**
     *
     */
    protected const NAME_KEY = '';

    /**
     *
     */
    protected const SLUG_KEY = '';

    /**
     *
     */
    protected const OBJECT_TYPE = '';

    /**
     *
     */
    protected const OBJECT_ARRAY_NAME = '';

    /**
     *
     */
    public function get(string $property)
    {
        return array_map(function ($object) use ($property) {
            return $object->{$property};
        }, $this->{static::OBJECT_ARRAY_NAME});
    }

    /**
     *
     */
    public function getIds()
    {
        return $this->get(static::ID_KEY);
    }

    /**
     *
     */
    public function getNames()
    {
        return $this->get(static::NAME_KEY);
    }

    /**
     *
     */
    public function getSlugs()
    {
        return $this->get(static::SLUG_KEY);
    }

    /**
     *
     */
    protected function diffCallback()
    {
        return function ($object1, $object2) {
            return $object1->{static::ID_KEY} - $object2->{static::ID_KEY};
        };
    }
}
